@extends('layouts.home')

@section('meta')
<meta name="description" content="{{ $page->meta_tag }}">
<meta name="keywords" content="{{ $page->meta_tag }}">
@endsection

@section('content')
    <!-- Page Header -->
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset( $setting->getSlides()[rand(0, count($setting->getSlides()) - 1)] )}}" class="w-full brightness-75  h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="relative text-white text-center space-y-2">
            <h1 class=" text-4xl md:text-6xl font-semibold outlined-text">{{$page->title}}</h1>
        </div>
    </section>

    <!-- Page -->
    <section class="w-full mx-auto max-w-7xl grid grid-cols-1 px-3 py-5 md:px-5 md:py-7">
        <div class=" space-y-2">
            <article class="space-y-4">
                <h2 class="text-xl md:text-3xl leading-tight font-bold line-clamp-2">{{$page->title}}</h2>
                <p>
                    {!! $page->body !!}
                </p>
            </article>
        </div>
    </section>
@endsection