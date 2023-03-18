<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="{{ $setting->getValue('G_SITE_META_DESC') }}">
        <meta name="keywords" content="{{ $setting->getValue('G_SITE_META_KEYWORD') }}">
        <meta name="author" content="{{ $setting->getValue('G_SITE_NAME') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('meta')
        <title>{{ $setting->getValue('G_SITE_NAME') }}  @yield('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @vite(['resources/js/frontpage.jsx'])
        @yield('css')
        @stack('style')
        @livewireStyles
        <wireui:scripts />
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="antialiased">
        @if(request()->cookie('accept') == null)
        <div class="fixed z-40 bottom-16 w-full" id="show-cookie">
            <div class="p-4 bg-white shadow-2xl border-2 border-gray-100 rounded max-w-5xl mx-auto">
                <div class="flex flex-col md:flex-row gap-2">
                    <div class="font-bold text-lg">{{ __('website.This site use cookies')}} |</div>
                    <div class="text-md flex-1">
                        {{ __('website.Some of them are essential with others used to serve you a customized holiday experience') }}
                        <a href="{{  route('page.show', ['page' => 'cookiepolicy'])  }}" class="underline"> {{ __('website.Learn more')}}.</a>
                    </div>
                    <button class="border-2 py-2 px-3" id="cookie">{{ __('website.Got It')}}</button>
                </div>
            </div>
        </div>
        @endif
        <div class="loader-container">
            <div class="web-spinner"></div>
        </div>
        <div class="w-full justify-center flex flex-col main-content">

            @include('layouts.partials.header')
            @yield('content')
            @include('layouts.partials.footer')

            @if($setting->getValue('G_WHATSAPP_FLOAT_ENABLE') == 1)
            <div class="fixed z-10 bottom-2 right-5">
                <a href="{{ $setting->getValue('G_WHATSAPP_URL') }}" target="_blank" class="flex flex-row items-center justify-center gap-2 bg-green-500 rounded-2xl px-4 py-2 scale-100 hover:scale-110 text-white">
                    <img src="{{ asset('images/wa_logo.png') }}" alt="action to call whatsapp" class="w-7 h-7">
                    <p>{{ $setting->getValue('G_WHATSAPP_TEXT') }}</p>
                </a>
            </div>
            @endif
        </div>
    </body>
    <script>
        const loaderContainer = document.querySelector('.loader-container');
        const mainContainer = document.querySelector('.main-content');
        loaderContainer.classList.remove('hidden');
        mainContainer.style.display = 'none';
        window.addEventListener('load', () => {
            setTimeout(() => {
                loaderContainer.classList.add('hidden');
                mainContainer.style.display = 'block';
            }, 800);
        });

        cookie = document.getElementById('cookie')
        showcookie = document.getElementById('show-cookie')

        if(cookie != undefined) {
            cookie.addEventListener('click' , () => {
                showcookie.style.display = 'none'
                fetch("{{ route('accept.cookie') }}")
            })
        }
    </script>
    @livewireScripts
    @yield('js')
    @stack('script')
</html>
