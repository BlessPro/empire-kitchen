<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /** List table */
    public function index(Request $request)
    {
        $employees = Employee::query()
            ->select([
                'id','staff_id','name','designation','phone','email',
                'nationality','dob','hometown','language','address','gps',
                'next_of_kin','relation','nok_phone','bank','branch','account_number',
                'commencement_date','avatar_path'
            ])
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.employee', compact('employees'));
    }

    /** Create page */
    public function addemployee()
    {
        $employee = null; // create mode
        return view('admin.addemployee', compact('employee'));
    }

    /** Store new employee */
    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_id'          => ['nullable','string','max:50','unique:employees,staff_id'],
            'name'              => ['required','string','max:255'],
            'designation'       => ['nullable','string','max:100'],
            'commencement_date' => ['nullable','date'],
            'phone'             => ['nullable','string','max:50'],
            'email'             => ['nullable','email','max:255','unique:employees,email'],

            'nationality'       => ['nullable','string','max:100'],
            'dob'               => ['nullable','date'],
            'hometown'          => ['nullable','string','max:255'],
            'language'          => ['nullable','string','max:100'],

            'address'           => ['nullable','string','max:255'],
            'gps'               => ['nullable','string','max:100'],

            'next_of_kin'       => ['nullable','string','max:255'],
            'relation'          => ['nullable','string','max:100'],
            'nok_phone'         => ['nullable','string','max:50'],

            'bank'              => ['nullable','string','max:100'],
            'branch'            => ['nullable','string','max:100'],
            'account_number'    => ['nullable','string','max:100'],

            'avatar'            => ['nullable','image','max:4096'],
        ]);

        // auto staff_id if empty
        if (empty($data['staff_id'])) {
            $next = (Employee::max('id') ?? 0) + 1;
            $data['staff_id'] = 'EMP-'.str_pad((string)$next, 4, '0', STR_PAD_LEFT);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('employees/avatars', 'public');
        }

        Employee::create($data);

        return redirect()->route('admin.employee')->with('success','Employee created.');
    }

    /** Edit page */
    public function editemployee(Employee $employee)
    {
        return view('admin.editemployee', compact('employee'));
    }

    /** Update */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name'              => ['required','string','max:255'],
            'designation'       => ['nullable','string','max:100'],
            'commencement_date' => ['nullable','date'],
            'phone'             => ['nullable','string','max:50'],
            'email'             => [
                'nullable','email','max:255',
                Rule::unique('employees','email')->ignore($employee->id)
            ],

            'nationality'       => ['nullable','string','max:100'],
            'dob'               => ['nullable','date'],
            'hometown'          => ['nullable','string','max:255'],
            'language'          => ['nullable','string','max:100'],

            'address'           => ['nullable','string','max:255'],
            'gps'               => ['nullable','string','max:100'],

            'next_of_kin'       => ['nullable','string','max:255'],
            'relation'          => ['nullable','string','max:100'],
            'nok_phone'         => ['nullable','string','max:50'],

            'bank'              => ['nullable','string','max:100'],
            'branch'            => ['nullable','string','max:100'],
            'account_number'    => ['nullable','string','max:100'],

            'avatar'            => ['nullable','image','max:4096'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($employee->avatar_path) {
                Storage::disk('public')->delete($employee->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('employees/avatars', 'public');
        }

        $employee->update($data);

        // go back to list (or use admin.editemployee if you want to stay)
        return redirect()->route('admin.employee')->with('success','Employee updated.');
    }
}
