@extends('layouts.home')

@section('content')
    <!-- Slide -->
    @if($package->images != null)
    <div class="w-full max-w-7xl mx-auto">
        <div id="animation-carousel" class="relative" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-72 overflow-hidden md:h-99" >
                @foreach($package->images as $image)
                <!-- Item 1 -->
                <div class="hidden brightness-90 duration-700 ease-in-out" data-carousel-item>
                    <span class="absolute text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 sm:text-3xl dark:text-gray-800">First Slide</span>
                    <img src="{{ $image->url }}" class="object-fill absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="{{ $image->file->name }}">
                </div>
                @endforeach
            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                @foreach($package->images as $index => $image)
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide {{$index}}" data-carousel-slide-to="{{$index}}"></button>
                @endforeach
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>
    @endif

    <!-- Content -->
    <section class="w-full mx-auto max-w-7xl flex flex-col md:flex-row gap-4 px-3 py-5 md:px-5 md:py-7">
        <div class="space-y-2 w-full md:w-4/6 lg:w-3/4">
            <article class="space-y-4">
                <h2 class="text-xl md:text-3xl leading-tight font-bold line-clamp-2">{{$package->title}}</h2>
                <p>
                    {!! $package->body !!}
                </p>
            </article>
        </div>
        <div class="w-full md:w-2/6 lg:w-1/4">
            <div class="top-32 sticky z-[30] px-2 space-y-2">
                @if($package->prices->count() > 0)
                <div class="w-full p-4 shadow-lg border-2 rounded-lg">
                    <div class="font-bold text-lg">Prices</div>
                    @foreach($package->prices as $price)
                    <div>
                        <ul>
                            <li>
                                - {{$price->quantity}} pax = IDR {{ number_format($price->price, '0', ',', '.') }} pax
                            </li>
                        </ul>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="w-full p-4 shadow-lg border-2 rounded-lg">
                    <div class="font-bold text-lg">Prices: {{ number_format($package->price, '0', ',', '.') }}</div>
                </div>
                @endif
                <livewire:package-item :package="$package"/>
            </div>
        </div>
    </section>
@endsection