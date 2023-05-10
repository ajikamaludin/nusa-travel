@extends('customer.partials.layout')

@section('main')
    <div class="px-4">
        <p class="text-2xl font-bold mb-6 border-b-2 border-gray-200">Api</p>
        <div class="flex flex-row">
            <div class="w-full">
                @if (session()->has('message'))
                    <x-alert type="{{ session()->get('message.type') }}" message="{{ session()->get('message.message') }}" />
                @endif
                <label for="token" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Token</label>
                <input type="text" disabled id="national_id"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="API Token" name="token" value="{{ $customer->token }}">
                <form method="POST" action="{{ route('customer.apitoken.regenerate') }}">
                    @csrf
                    <button type="submit"
                        class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('website.Regenerate') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
