@extends('customer.partials.layout')

@section('main')
    <div class="px-4">
        <p class="text-2xl font-bold mb-6 border-b-2 border-gray-200">{{ __('website.Order')}}</p>
            @if (session()->has('message'))
                <x-alert type="{{ session()->get('message.type') }}" message="{{ session()->get('message.message') }}" />
            @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('website.Order')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('website.Date')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('website.Amount')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('website.Status')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('website.Action')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            #{{ $order->order_code }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $order->order_date_formated }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($order->total_amount, '0', ',', '.') }}
                        </td>
                        <td class="px-6 py-4 {{ $order->payment_status_color }}">
                            {{ $order->payment_status_text }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('customer.order', $order) }}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('website.View')}}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-1">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection