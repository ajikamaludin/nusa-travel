<x-mail::message>
# Hai, {{ $customer->name }}

## Reset Password Request
please click button below to reset your account to new password.

<x-mail::button url="{{ route('customer.forgot-password.show', $customer) }}">
    Reset
</x-mail::button>

<div> if button not work please click on link below : </div>
<div>
    <a href="{{ route('customer.forgot-password.show', $customer) }}">
        {{ route('customer.forgot-password.show', $customer) }}
    </a>
</div>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
