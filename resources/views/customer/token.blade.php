@extends('customer.partials.layout')

@section('main')
<div class="px-4">
    <p class="text-2xl font-bold mb-6 border-b-2 border-gray-200">Api</p>
    <div class="flex flex-row">
        <div class="w-full">
            <label for="token" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">    Token</label>
            <input type="text" disabled id="national_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="API Token" name="token" value="{{ $customer->token }}">
        </div>
    </div>
</div>

@endsection