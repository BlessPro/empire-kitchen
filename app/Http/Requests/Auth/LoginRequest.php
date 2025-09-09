<?php

namespace App\Http\Requests\Auth;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // keep the same input names so your form doesn't need changes
            'name'     => ['required', 'string', 'max:255'], // employee name OR staff code
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $identifier = Str::lower((string) $this->input('name')); // same field name as before
        $password   = (string) $this->input('password');
        $remember   = (bool) $this->boolean('remember');

        // 1) Find employee by staff_id (EMP-xxxx) OR by name (case-insensitive)
        $employeeQuery = Employee::query();

        if (Str::startsWith($identifier, 'emp-')) {
            $employeeQuery->whereRaw('LOWER(staff_id) = ?', [$identifier]);
        } else {
            $employeeQuery->whereRaw('LOWER(name) = ?', [$identifier]);
        }

        $employees = $employeeQuery->select('id','name','staff_id')->get();

        if ($employees->isEmpty()) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'name' => trans('auth.failed'), // "These credentials do not match our records."
            ]);
        }

        // If multiple employees share the same name, stop unless they used staff_id
        if ($employees->count() > 1 && !Str::startsWith($identifier, 'emp-')) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'name' => 'Multiple employees share this name. Please use your Staff ID (e.g., EMP-0004).',
            ]);
        }

        $employee = $employees->first();

        // 2) Resolve the User by FK
        $user = User::where('employee_id', $employee->id)->first();
        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'name' => 'This employee does not have a user account.',
            ]);
        }

        // 3) Verify password
        if (! Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'password' => trans('auth.password'), // "The provided password is incorrect."
            ]);
        }

        // 4) Log in the user; update last_seen_at if you like
        Auth::login($user, $remember);
        $user->forceFill(['last_seen_at' => now()])->save();

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'name' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        // Throttle by ip + identifier (name or staff_id)
        return Str::transliterate(
            Str::lower((string) $this->input('name')).'|'.$this->ip()
        );
    }
}
