<p>Hi {{ $user->employee?->name ?? $user->name ?? 'there' }},</p>
<p>Your Empire Kitchens account has been created.</p>

@if(!empty($plainPassword))
    <p><strong>Email:</strong> {{ $user->employee?->email ?? $user->email }}</p>
    <p><strong>Temporary password:</strong> {{ $plainPassword }}</p>
@endif

<p>You can log in here: {{ url('/login') }}</p>

<p>Thank you,<br>Empire Kitchens</p>
