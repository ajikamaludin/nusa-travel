<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="{{ $setting->getValue('G_SITE_META_DESC') }}">
        <meta name="keywords" content="{{ $setting->getValue('G_SITE_META_KEYWORD') }}">
        <meta name="author" content="{{ $setting->getValue('G_SITE_NAME') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $setting->getValue('G_SITE_NAME') }}  @yield('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @vite(['resources/js/frontpage.jsx'])
        @yield('css')
    </head>
    <body class="antialiased">
        <div class="loader-container">
            <div class="web-spinner"></div>
        </div>
        <div class="w-full justify-center flex flex-col main-content">
        @include('layouts.partials.header')
        @yield('content')
        @include('layouts.partials.footer')
        </div>
    </body>
    <script>
        const loaderContainer = document.querySelector('.loader-container');
        const mainContainer = document.querySelector('.main-content');
        window.addEventListener('load', () => {
            loaderContainer.classList.remove('hidden');
            mainContainer.style.display = 'none';
            setTimeout(() => {
                loaderContainer.classList.add('hidden');
                mainContainer.style.display = 'block';
            }, 800);
        });
    </script>
    @yield('js')
</html>
