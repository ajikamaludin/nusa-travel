@extends('layouts.home')

@section('content')
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <div class="mx-auto w-2/3 p-6 bg-white border border-b-0 border-gray-200 rounded-t-lg shadow flex flex-col items-center">
                <div class="mb-6 text-left">
                    <div class="text-2xl font-extrabold">Order</div>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Order Code
                                </th>
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
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <p>{{ $order->order_code }} </p>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $order->track_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($order->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $order->quantity }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($order->amount * $order->quantity, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $order->payment_status }}
                                </td>
                                <td>
                                    @if($order->payment_status != 'PAID')
                                    <a href="{{ route('fastboat.show', $order->id) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">Detail</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endsection