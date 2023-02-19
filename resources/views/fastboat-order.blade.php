@extends('layouts.home')

@section('content')
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <div class="mx-auto w-2/3 p-6 bg-white border border-b-0 border-gray-200 rounded-t-lg shadow flex flex-col items-center">
                <div class="mb-6 text-left">
                    <div class="text-2xl font-extrabold">Detail Order </div>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Ticket
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <p>{{ $track->source->name }} ({{ $track->arrival_time }}) - {{ $track->destination->name }} ({{ $track->departure_time }}) </p>
                                </th>
                                <td class="px-6 py-4">
                                    {{ number_format($track->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $qty }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($track->price * $qty, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="w-full flex justify-end mt-4">
                    <div id="pay-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">Pay</div>
                </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $setting->getValue('midtrans_client_key') }}"></script>
<script>
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        fetch("{{ route('api.fastboat.store', $order) }}", { method: 'POST' })
        .then(res => res.json())
        .then(res => {
            snap.pay(res.snap_token, {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                    fetch("{{ route('api.fastboat.update', $order) }}", { 
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
                    fetch("{{ route('api.fastboat.update', $order) }}", { 
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
                    fetch("{{ route('api.fastboat.update', $order) }}", { 
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ payment_status: 2, result })
                    })
                    .then(res => res.json())
                    .then(res => {
                        location.href = res.show
                    })
                }
            });
        })
    });
</script>
@endsection