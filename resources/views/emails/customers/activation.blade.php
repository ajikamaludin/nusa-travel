<x-mail::message>
# Hai, {{ $customer->name }}

## Welcome to {{ config('app.name', 'Nusa Travel') }}
To begin use our service please active your account with click this activation button down below.

<x-mail::button url="{{ route('customer.active', $customer) }}">
Active
</x-mail::button>

if button not work please click on link below :
<a href="{{ route('customer.active', $customer) }}">
    {{ route('customer.active', $customer) }}
</a>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
