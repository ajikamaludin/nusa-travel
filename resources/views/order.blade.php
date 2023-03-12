@extends('layouts.home')

@section('content')
<div class="w-full mx-auto max-w-7xl px-2 py-5">
    <div class="mx-auto p-6 flex flex-col">
        <div class="font-bold text-3xl mb-5">Order #{{ $order->order_code }}</div>
        <div class="w-full flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-3/4">
                <div class="flex flex-col gap-4">
                    @foreach($order->items as $item)
                    <div class="flex flex-col shadow-lg px-4 py-2 border-2 rounded-md">
                        <div class="flex flex-row justify-between border-b-2">
                            <div class="font-bold">
                                {!! $item->detail !!}
                            </div>

                            <div class="flex flex-row justify-end gap-2 items-center">
                                {{ $item->quantity }}
                            </div>
                        </div>
                        <div class="flex flex-row justify-end py-2">
                            <div class="font-bold">
                                {{ number_format($item->quantity * $item->amount, '0', ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="w-full lg:flex-1">
                <div class="shadow-lg p-4 border-2 rounded-lg">
                    <form wire:submit.prevent="submit">
                        <div>
                            <div class="mt-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $order->customer->name }}" disabled autocomplete="off">
                            </div>
                            
                            <div class="mt-2">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " autocomplete="off" value="{{ $order->customer->phone }}" disabled>
                            </div>
                            <div class="mt-2">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nation</label>
                                <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " autocomplete="off" value="{{ $order->customer->nation }}" disabled>
                            </div>
                            <div class="mt-2">
                                <label for="national_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">National ID</label>
                                <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " autocomplete="off" value="{{ $order->customer->national_id }}" disabled>
                            </div>
                            <div class="mt-2">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " autocomplete="off" value="{{ $order->customer->email }}" disabled>
                            </div>
                        </div>
                        @if($order->promos->count() > 0)
                        <div class="p-4 my-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                            <span class="font-medium">Promo aplied!</span> 
                            @foreach($order->promos as $promo)
                                <div>{{ $promo->promo->name }} ( -{{ number_format( $promo->promo_amount, 0, ',', '.') }} )</div>
                            @endforeach
                        </div>
                        @endif
                        <div class="font-bold text-xl mt-5 border-b-2">Total : {{ number_format($order->total_amount, '0', ',', '.') }}</div>
                        <div class="font-bold text-xl text-center mt-5 {{ $order->payment_status_color }} ">
                            {{ $order->payment_status_text }}
                        </div>
                        <div class="flex flex-row w-full justify-center mt-5">
                        @if($order->payment_status == null) 
                            <a href="{{ route('customer.process-payment', $order) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5" id="pay-button">Process Payment</a>
                        @endif
                        </div>
                    </form>
                </div>
            </div>
            </div>
    </div>
</div>
@endsection
