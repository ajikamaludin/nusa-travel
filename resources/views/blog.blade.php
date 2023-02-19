@extends('layouts.home')

@section('content')
    <!-- Hero Blog -->
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset('images/2.jpg')}}" class="w-full brightness-75  h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="relative text-white text-center space-y-2">
            <h1 class=" text-4xl md:text-6xl font-semibold">Blog</h1>
            <p class="text-base md:text-lg">Explore knowledge, tours and more</p>
        </div>
    </section>

    <!-- Blog  -->
    <section class="w-full mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-4 gap-4 py-2 md:py-5 px-1">
        @foreach($posts as $a)
        <div class="hover:-translate-y-2 ease-in duration-150 shadow bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
            <a href="{{ route('blog.post', $a) }}">
                <img class="rounded-t-lg" src="{{asset($a->cover_image)}}" alt="" />
            </a>
            <div class="p-3 md:p-5 space-y-1">
                <a href="#">
                    <h4 class="font-bold text-xl text-gray-900 dark:text-white line-clamp-1">{{ $a->title }}</h4>
                </a>
                <span class="line-clamp-1 text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, velit.</span>
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-300">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-gray-500">
                        300 views
                    </span>
                </div>
                <div>
                    <span class="py-1 px-2 text-xs font-bold rounded bg-gray-200 text-gray-700 dark:text-gray-400">tag1</span>
                    <span class="py-1 px-2 text-xs font-bold rounded bg-gray-200 text-gray-700 dark:text-gray-400">tag2</span>
                </div>
            </div>
        </div>
        @endforeach
    </section>
@endsection
