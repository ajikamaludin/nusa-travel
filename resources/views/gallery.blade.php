@extends('layouts.home')

@push('style')
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="/magnific-popup/app.css">
@endpush

@push('script')
<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Magnific Popup core JS file -->
<script src="/magnific-popup/app.js"></script>

<script>
    $(document).ready(function() {
        $('.parent-container').magnificPopup({
            delegate: 'figure', // child items selector, by clicking on it popup will open
            type: 'image',
            gallery:{
                enabled: true,
                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function
            }
        });
    });
</script>
@endpush

@section('content')
    <!-- Hero Blog -->
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset( $images[rand(0, count($images) - 1)]['path_url'] )}}" loading="lazy" class="w-full brightness-75  h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="relative text-white text-center space-y-2">
            <h1 class=" text-4xl md:text-6xl font-semibold outlined-black">{{ __('website.Inspiring your holiday')}}</h1>
            <p class="text-base md:text-lg">{{ __('website.Explore fun, culture and more')}}</p>
        </div>
    </section>

    <!-- Blog  -->
    <section class="w-full mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 py-2 md:py-5 px-1 parent-container">
        @foreach($images as $index => $image)
        <figure class="{{ $index == 0 ? 'md:col-span-2' : '' }} relative transition-all duration-300 cursor-pointer filter  grayscale hover:grayscale-0" href="{{ $image->path_url }}">
            <img class="rounded-lg object-cover h-full w-full" src="{{ $image->path_url }}" loading="lazy" alt="{{ $image->name }}"/>
            <figcaption class="absolute px-4 text-xl text-white outlined-black bottom-6">
                <p>{{ $image->name }}</p>
            </figcaption>
        </figure>
        @endforeach
    </section>
    <div class="max-w-7xl mx-auto mb-5 px-1">
        {{$images->links()}}
    </div>
@endsection
