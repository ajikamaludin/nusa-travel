@extends('layouts.home')

@section('content')
    <!-- Sign Up -->
    <div class="w-full mx-auto max-w-7xl px-2 py-10">
        <div class="mx-auto max-w-sm p-6 bg-white border border-b-0 border-gray-200 rounded-t-lg shadow">
            <form method="POST" action="{{ route('customer.signup') }}">
                @csrf
                <div class="mb-12 text-center">
                    <div class="text-2xl font-extrabold">{{ __('website.Signup To')}} {{$setting->getValue('G_SITE_NAME')}}</div>
                    <div class="text-gray-500">{{ __('website.get our gratest tour services') }}</div>
                </div>
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Name')}}</label>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 @enderror" placeholder="{{ __('website.Your Name')}}" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Email')}}</label>
                    <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 @enderror" placeholder="your@email.com" required name="email" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Phone Number')}}</label>
                    <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('phone') border-red-500 @enderror" placeholder="+1415552671"  required name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Password')}}</label>
                    <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') border-red-500 @enderror" required name="password" value="{{ old('password') }}">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                    <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required>
                    </div>
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('website.I agree with the')}} <a href="{{ route('page.show', ['page' => 'term-of-service']) }}" class="text-blue-600 hover:underline dark:text-blue-500">{{ __('website.terms and conditions')}}</a>.</label>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">{{ __('website.Sign Up')}}</button>
            </form>
        </div>
        <div class="mx-auto max-w-sm bg-gray-100 px-6 pb-6 pt-4 border border-t-0 rounded-b-lg shadow">
            <div class="w-full flex flex-row justify-between items-center">
                <div>{{ __('website.Already have a account?')}}</div>
                <div>
                    <a href="{{route('customer.login')}}" class="ring-1 ring-gray-500 bg-gray-100 hover:text-white hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">{{ __('website.Login')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection