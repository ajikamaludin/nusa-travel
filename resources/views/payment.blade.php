@extends('layouts.home')

@section('content')
    <div class="w-full mx-auto max-w-7xl px-2 py-5">
        <div class="mx-auto p-6 flex flex-col">
            <div class="font-bold text-3xl mb-5" id="wait">{{ __('website.Waiting Payment')}} ....</div>
            <div class="font-bold text-2xl" id="status"></div>
            <div class="w-full flex mt-4">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 hidden" id="pay-button">{{ __('website.Process Payment')}}</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
@if(app()->isProduction()) 
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $setting->getValue('midtrans_client_key') }}"></script>
@else
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $setting->getValue('midtrans_client_key') }}"></script>
@endif
<script>
    const action = {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
                fetch("{{ route('api.order.update', $order) }}", { 
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ payment_status: 1, result })
                })
                .then(res => res.json())
                .then(res => {
                    location.href = res.show
                })
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
                fetch("{{ route('api.order.update', $order) }}", { 
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ payment_status: 3, result })
                })
                .then(res => res.json())
                .then(res => {
                    location.href = res.show
                })
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
                fetch("{{ route('api.order.update', $order) }}", { 
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ payment_status: 2, result })
                })
                .then(res => res.json())
                .then(res => {
                    location.href = res.show
                })
            },
            onClose: function() {
                document.getElementById('wait').classList.add('hidden')
                document.getElementById('pay-button').classList.remove('hidden')
            }
        }
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        snap.pay('{{ $snap_token }}', action);
    })
    snap.pay('{{ $snap_token }}', action);
</script>
@endsection