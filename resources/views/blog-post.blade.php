@extends('layouts.home')

@section('meta')
<meta name="description" content="{{ $post->meta_tag }}">
<meta name="keywords" content="{{ $post->meta_tag }}">
@endsection

@section('content')
    <!-- Blog Post Header -->
    <section class="w-full max-w-7xl mx-auto">
        <img src="{{asset($post->cover_image)}}" class="w-full h-96 rounded object-cover" alt="...">
    </section>

    <!-- Blog Post -->
    <section class="w-full mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-[1fr_4fr] gap-4 px-3 py-5 md:px-5 md:py-7">
        <div class="hidden md:block">
            <div class="top-32 sticky z-[90] px-2 space-y-2">
                <span class="text-gray-500 text-sm">{{ __('website.You are reading')}}</span>
                <h2 class="text-base leading-tight  font-bold">{{$post->title}}</h2>
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-300">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-500">
                        {{ $post->visitors_count }} views
                    </span>
                </div>
            </div>
        </div>
        <div class=" space-y-2">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            {{ __('website.Home')}}
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('blog.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ __('website.Blog')}}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-bold text-gray-500 md:ml-2 dark:text-gray-400 line-clamp-1">{{$post->title}}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <article class="">
                <h2 class="text-xl md:text-3xl leading-tight font-bold line-clamp-2">{{$post->title}}</h2>
                <div>
                    <span class="px-1 text-gray-500 text-lg">{{ $post->publish_at_human }}</span>
                    <span class="px-1 text-blue-600 font-semibold text-lg">{{ $post->creator->name }}</span>
                </div>
                <p class="pt-5">
                    {!! $post->body !!}
                </p>
            </article>
        </div>
    </section>
@endsection