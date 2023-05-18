<x-mail::message>
# Hai, {{ $customer->name }}

## Welcome to {{ config('app.name', 'Nusa Travel') }}
To begin use our service please active your account with click this activation button down below.

<x-mail::button url="{{ route('customer.active', $customer) }}">
    Active
</x-mail::button>


<div> if button not work please click on link below : </div>
<div>
    <a href="{{ route('customer.active', $customer) }}">
        {{ route('customer.active', $customer) }}
    </a>
</div>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
