@extends('layouts.home')

@section('content')
    <!-- Blog Post Header -->
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset( $setting->getSlides()[rand(0, count($setting->getSlides()) - 1)] )}}" class="w-full brightness-75  h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="relative text-white text-center space-y-2">
            <h1 class=" text-4xl md:text-6xl font-semibold outlined-black">FAQ</h1>
        </div>
    </section>

    <!-- Blog Post -->
    <section class="w-full mx-auto max-w-7xl grid grid-cols-1 px-3 py-5 md:px-5 md:py-7">
        <div class=" space-y-2">
            <article class="space-y-4 text-center max-w-4xl mx-auto">
                <div class="relative mx-auto w-1/2 py-6">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <form action="{{ route('page.faq') }}">
                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Topic's" name="q" value="{{ $q }}"/>
                    </form>
                </div>
                <div class="flex flex-col text-xl" id="accordion-collapse" data-accordion="collapse">
                    <!-- 1 -->
                    @foreach($faqs as $index => $faq)
                    <button type="button" class="w-full border-b-2 inline-flex justify-between py-4 px-1 items-center" id="accordion-collapse-heading-{{$index}}" data-accordion-target="#accordion-collapse-body-{{$index}}" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                        <p class="font-bold text-lg md:text-xl">{{ $faq->question }}<p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                    <div id="accordion-collapse-body-{{$index}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$index}}">
                        <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <p class="text-base  text-gray-500">
                                {!! $faq->answer !!}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection