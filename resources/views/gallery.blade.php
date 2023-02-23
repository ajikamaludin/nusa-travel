@extends('layouts.home')

@section('content')
    <!-- Hero Blog -->
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset( $setting->getSlides()[rand(0, count($setting->getSlides()) - 1)] )}}" class="w-full brightness-75  h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="relative text-white text-center space-y-2">
            <h1 class=" text-4xl md:text-6xl font-semibold">Insparing your holiday</h1>
            <p class="text-base md:text-lg">Explore fun, culture and more</p>
        </div>
    </section>

    <!-- Blog  -->
    <section class="w-full mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-4 gap-4 py-2 md:py-5 px-1">
        @foreach($images as $index => $image)
        <figure class="{{ $index == 0 ? 'col-span-2' : '' }} relative transition-all duration-300 cursor-pointer filter  grayscale hover:grayscale-0">
            <img class="rounded-lg object-cover h-full w-full" src="{{ $image->path_url }}" alt="{{ $image->name }}"/>
            <figcaption class="absolute px-4 text-xl text-white outlined-black bottom-6">
                <p>{{ $image->name }}</p>
            </figcaption>
        </figure>
        @endforeach
    </section>
    <div class="max-w-7xl mx-auto mb-5">
        {{$images->links()}}
    </div>
@endsection
