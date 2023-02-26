@extends('layouts.home')

@section('content')
    <!-- Login -->
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <!-- <div class="flex-1">
            <div class="text-center md:text-left text-xl font-light text-opacity-80">Your One-Stop Destination for Island Hopping in Indonesia</div>
        </div> -->
        <div class="mx-auto max-w-7xl bg-white flex flex-col md:flex-row gap-2">
            <div class="px-4 py-6 border border-b-0 border-gray-200 rounded-t-lg shadow w-full md:w-1/4">
                <div class="flex flex-row w-full justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>

                </div>
                <div class="mb-6 text-center">
                    <div class="text-2xl font-extrabold">Hai, {{ auth()->user()->name }}</div>
                </div>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('customer.profile') }}" class="rounded-lg shadow p-2 hover:bg-gray-200">Profile</a>
                    <a href="{{ route('customer.orders') }}" class="rounded-lg shadow p-2 hover:bg-gray-200">Order</a>
                </div>
                <form method="POST" action="{{ route('customer.logout') }}" class="pt-10">
                    @csrf
                    <input type="hidden" name="">
                    <button type="submit" class="rounded-lg shadow p-2 w-full hover:bg-gray-200 text-left">{{__('website.Logout')}}</button>
                </form>
            </div>
            <div class="w-full md:w-3/4">
                @yield('main')
            </div>
        </div>
    </div>
@endsection