@component('mail::message')
<div style="text-align:center; margin-bottom: 12px;">
  <img src="{{ $logoUrl ?? asset('empire-kitchengold-icon.png') }}" alt="Empire Kitchen" style="height:60px; width:auto;">
</div>

# Reset Your Password

Hi {{ $user->employee->name ?? $user->name ?? 'there' }},

We received a request to reset your Empire Kitchen account password. Click the button below to set a new password.

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

If you didn’t request this, you can safely ignore this email.

Thanks,
{{ $appName ?? config('app.name') }} Team

@slot('subcopy')
If you’re having trouble clicking the "Reset Password" button, copy and paste this URL into your browser:
<br>
<a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
@endslot
@endcomponent

