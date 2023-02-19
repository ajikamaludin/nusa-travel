@extends('layouts.home')

@section('content')
    <!-- Login -->
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <!-- <div class="flex-1">
            <div class="text-center md:text-left text-xl font-light text-opacity-80">Your One-Stop Destination for Island Hopping in Indonesia</div>
        </div> -->
        <div class="mx-auto max-w-sm p-6 bg-white border border-b-0 border-gray-200 rounded-t-lg shadow">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('customer.signup') }}">
                @csrf
                <div class="mb-12 text-center">
                    <div class="text-2xl font-extrabold">Signup To {{$setting->getValue('G_SITE_NAME')}}</div>
                    <div class="text-gray-500">get our gratest tour services</div>
                </div>
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 @enderror" placeholder="john doe" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                    <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 @enderror" placeholder="name@nusa.travel" required name="email" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your phone</label>
                    <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('phone') border-red-500 @enderror" placeholder="+1 41 555 2671"  required name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                    <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') border-red-500 @enderror" required name="password" value="{{ old('password') }}">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Sign Up</button>
            </form>
        </div>
        <div class="mx-auto max-w-sm bg-gray-100 px-6 pb-6 pt-4 border border-t-0 rounded-b-lg shadow">
            <div class="w-full flex flex-row justify-between items-center">
                <div>Already have a account?</div>
                <a href="{{route('customer.login')}}" class="ring-1 ring-gray-500 bg-gray-100 hover:text-white hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Login</a>
            </div>
        </div>
    </div>
@endsection