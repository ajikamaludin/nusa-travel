@extends('layouts.home')

@section('content')
    <!-- Login -->
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <!-- <div class="flex-1">
            <div class="text-center md:text-left text-xl font-light text-opacity-80">Your One-Stop Destination for Island Hopping in Indonesia</div>
        </div> -->
        <div class="mx-auto max-w-sm p-6 bg-white border border-b-0 border-gray-200 rounded-t-lg shadow flex flex-col items-center">
                <div class="mb-6 text-center">
                    <div class="text-2xl font-extrabold">Welcome To {{$setting->getValue('G_SITE_NAME')}}</div>
                </div>  
                <div>
                    Welcome {{ auth()->user()->name }}
                </div>
                <form method="POST" action="{{ route('customer.logout') }}" class="pt-10">
                    @csrf
                    <input type="hidden" name="">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">{{__('website.Logout')}}</button>
                </form>
            
        </div>
    </div>
@endsection