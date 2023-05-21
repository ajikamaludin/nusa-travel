<x-mail::message>
# Hai, {{ $order->customer->name }}

## Order #{{$order->order_code}}
Waiting for payment utils {{ $wait }} WIB

Immediately make payment for your order with the following details:

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

@if($order->promos()->count() > 0)
@component('mail::panel')
    Promo Applied <br/>
    @foreach($order->promos as $promo)
        {{ $promo->promo->name }} ( {{ $promo->promo_formated }} )
    @endforeach
@endcomponent
@endif

<x-mail::button :url="route('customer.process-payment', $order)">
Process to payment
</x-mail::button>

@component('mail::subcopy')
    By clicking the Payment button. you agree to the 
    <a href="{{ route('page.show', ['locale'=> 'en', 'page' => 'term-of-service']) }}" target="_blank" class="text-blue-500">Terms and Conditions </a>
    and 
    <a href="{{ route('page.show', ['locale'=> 'en', 'page' => 'privacy-policy']) }}" target="_blank" class="text-blue-500">Privacy and Policy</a>
@endcomponent
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
