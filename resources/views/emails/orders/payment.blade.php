<x-mail::message>
# Hai, {{ $customer->name }}

## Order #SHIWCY12032023
Waiting for payment Saturday, 04 March 2023, 13:08 WIB
    
Immediately make payment for your order with the following details:

@component('mail::table')
| Item          | Quantity      | Subtotal   |
| ------------- |:-------------:| ----------:|
| MENO - PENIDA (Fastboat)

22:00 - 23:00

16-03-2023

Dropoff: BANDARA

@ 10 .000     | Centered      | $10        |
@endcomponent

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
