@extends('layouts.home')

@section('content')
    <!-- Hero Blog -->
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset( $setting->getSlides()[rand(0, count($setting->getSlides()) - 1)] )}}" class="w-full brightness-75  h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="relative text-white text-center space-y-2">
            <h1 class=" text-4xl md:text-6xl font-semibold outlined-black">Tour Packages</h1>
            <p class="text-base md:text-lg">Provide best experiences for yout holiday</p>
        </div>
    </section>

    <!-- Blog  -->
    <section class="w-full mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-4 gap-4 py-2 md:py-5 px-1">
        @foreach($packages as $index => $package)
        <div class="hover:-translate-y-2 ease-in duration-150 shadow bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 {{ $index == 0 ? 'md:col-span-2' : '' }}">
            <a href="{{ route('tour-packages.show', $package) }}">
                <img class="rounded-t-lg {{ in_array($index, [1,2])  ? 'md:h-4/6' : ''}}" src="{{asset($package->cover_image)}}" alt="" />
            </a>
            <div class="p-3 md:p-5 space-y-1">
                <a href="{{ route('tour-packages.show', $package) }}">
                    <h4 class="font-bold text-xl text-gray-900 dark:text-white line-clamp-1">{{ $package->title }}</h4>
                </a>
                <span class="mb-3 py-1 px-2 text-xs font-bold rounded bg-gray-200 text-gray-700 dark:text-gray-400">Instant Confirmation</span>
                <div class="pt-3">
                    From
                    <span class="text-base font-bold">Rp. {{ number_format($package->price, '0', ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </section>
    <div class="max-w-7xl mx-auto mb-5 px-1">
        {{$packages->links()}}
    </div>
@endsection
