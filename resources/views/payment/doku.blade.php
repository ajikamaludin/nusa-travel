@extends('layouts.home')

@section('content')
    <div class="w-full mx-auto max-w-7xl px-2 py-5">
        <div class="mx-auto p-6 flex flex-col">
            <div class="font-bold text-3xl mb-5" id="wait">{{ __('website.Waiting Payment')}} ....</div>
            <div class="font-bold text-2xl" id="status"></div>
            <div class="w-full flex mt-4">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5" id="pay-button">{{ __('website.Process Payment')}}</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
@if(app()->isProduction()) 
<script src="https://jokul.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>
@else
<script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>
@endif
<script>
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        loadJokulCheckout("{{ $payment_url }}"); // Replace it with the response.payment.url you retrieved from the response
    })
    loadJokulCheckout("{{ $payment_url }}"); // Replace it with the response.payment.url you retrieved from the response
</script>
@endsection