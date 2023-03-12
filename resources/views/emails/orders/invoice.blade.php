<x-mail::message>
# Hai, {{ $order->customer->name }}

## Order #{{$order->order_code}}
# Payment is verified and the order has been record

This mail is valid tickets of your order with the following details:

@component('mail::table')

| Item                             | Date                       | Quantity             | Price            | Subtotal                                |
| -------------------------------- |:--------------------------:|:--------------------:|:----------------:|:---------------------------------------:|
@foreach($order->items as $item)
| <x-item-payment :item='$item' /> | {{ $item->date_formated }} | {{ $item->quantity }} |{{ $item->price }}| {{ $item->subtotal }}                  |
@endforeach
@if($order->total_discount > 0)
| Discount                         |                             |                       |                 | {{ $order->discount_formated }}        |
@endif
| <h1>Total</h1>                   |                             |                       |                 | <h1>{{ $order->amount_formated }}</h1> |
@endcomponent

@component('mail::panel')
    {{ $order->payment_status_text }}
@endcomponent

@component('mail::subcopy')
    Any order with this email prove that you accepted and agree to the 
    <a href="{{ route('page.show', ['page' => 'term-of-service']) }}" target="_blank" class="text-blue-500">Terms and Conditions </a>
    and 
    <a href="{{ route('page.show', ['page' => 'privacy-policy']) }}" target="_blank" class="text-blue-500">Privacy and Policy</a>
@endcomponent
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
