@extends('layouts.home')

@section('content')
    <!-- Forgot Password -->
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <div class="mx-auto max-w-sm p-6 bg-white border border-b-0 border-gray-200 rounded-t-lg shadow">
            <form method="POST" action="{{ route('customer.forgot-password.update', $customer) }}">
                @csrf
                <div class="mb-6">
                    <div class="text-2xl font-extrabold">{{__('website.Create New Password')}}</div>
                </div>

                @if (session()->has('message'))
                    <x-alert type="{{ session()->get('message.type') }}" message="{{ session()->get('message.message') }}" />
                @endif
                <div class="mb-6">
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Password') }}</label>
                    <input type="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required name="password" value="">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Password Confirmation') }}</label>
                    <input type="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required name="password_confirmation" value="">
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">{{ __('website.Change')}}</button>
            </form>
        </div>
        <div class="mx-auto max-w-sm bg-gray-100 px-6 pb-6 pt-4 border border-t-0 rounded-b-lg shadow">
            <div class="w-full flex flex-row justify-between items-center">
                <div>{{ __('website.No account yet? Sign up now!') }}</div>
                <div>
                    <a href="{{ route('customer.signup') }}"
                        class="ring-1 ring-gray-500 bg-gray-100 hover:text-white hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">{{ __('website.Sign Up') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
