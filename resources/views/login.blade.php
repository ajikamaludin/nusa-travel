@extends('layouts.home')

@section('content')
    <!-- Login -->
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <!-- <div class="flex-1">
            <div class="text-center md:text-left text-xl font-light text-opacity-80">Your One-Stop Destination for Island Hopping in Indonesia</div>
        </div> -->
        <div class="mx-auto max-w-sm p-6 bg-white border border-b-0 border-gray-200 rounded-t-lg shadow">
            <form method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="mb-6 text-center">
                    <div class="text-2xl font-extrabold">{{ __('website.Welcome To')}} {{$setting->getValue('G_SITE_NAME')}}</div>
                </div>
                @if(session()->has('message'))
                <x-alert type="{{ session()->get('message.type') }}" message="{{ session()->get('message.message') }}"/>
                @endif
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Email')}}</label>
                    <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="your@email.com" required name="email" value="{{ old('email') }}">
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Password')}}</label>
                    <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="password" value="{{ old('password') }}">
                </div>
                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                    <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" name="remember">
                    </div>
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">{{__('website.Login')}}</button>
            </form>
        </div>
        <div class="mx-auto max-w-sm bg-gray-100 px-6 pb-6 pt-4 border border-t-0 rounded-b-lg shadow">
            <div class="w-full flex flex-row justify-between items-center">
                <div>{{ __('website.No account yet? Sign up now!')}}</div>
                <div>
                    <a href="{{route('customer.signup')}}" class="ring-1 ring-gray-500 bg-gray-100 hover:text-white hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">{{__('website.Sign Up')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection