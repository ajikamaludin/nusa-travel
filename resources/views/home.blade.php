@extends('layouts.home')

@section('content')
    <!-- slide images -->
    <div class="w-full mx-auto">
        <div id="animation-carousel" class="relative" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-72 overflow-hidden md:h-99" >
                @foreach($setting->getSlides() as $slide)
                <!-- Item 1 -->
                <div class="hidden brightness-90 duration-700 ease-in-out" data-carousel-item>
                    <span class="absolute text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 sm:text-3xl dark:text-gray-800">First Slide</span>
                    <img src="{{asset($slide)}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover h-full" alt="...">
                </div>
                @endforeach
            </div>
            <!-- Slider indicators -->
            <!-- <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                @foreach($setting->getSlides() as $slide)
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                @endforeach
            </div> -->
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

            <div class="absolute z-40 top-14 lg:top-16 left-1/2 -translate-x-1/2 w-full lg:w-2/3 mx-auto h-60 lg:px-0 px-4">
                <div class="text-center md:text-left text-5xl font-extrabold text-white outlined-text">{{$setting->getValue('G_SITE_WELCOME')}}</div>
                <div class="text-center md:text-left text-xl font-light text-white text-opacity-80">{{$setting->getValue('G_SITE_SUBWELCOME')}}</div>
            </div>

            <div class="block mt-5 md:absolute z-40 md:-bottom-44 md:bottom-24 md:left-1/2 md:-translate-x-1/2 w-full lg:w-2/3 mx-auto h-60 ">
                <div>
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500">
                        <li class="">
                            <a href="#" aria-current="page" class="inline-block p-3 font-bold bg-blue-600 text-white rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Fastboat</a>
                        </li>
                        <li class="">
                            <a href="{{ route('car.index') }}" class="inline-block p-3 font-bold rounded-t-lg bg-gray-100 hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Car Rentals</a>
                        </li>
                    </ul>
                </div>
                <div class="bg-white rounded-b-xl rounded-r-xl border-gray-200 shadow-xl px-8 py-6">
                    <x-fastboat-schedule ways="1" from="" to="" :date="now()->format('Y-m-d')" :rdate="now()->addDays(2)->format('Y-m-d')" passengers=''/>
                </div>
            </div>
        </div>
    </div>

    <!-- why NT -->
    <div class="w-full max-w-7xl mx-auto pt-80 md:mt-20 md:mt-5 md:pt-5 px-2 text-center">
        <div class="grid grid-cols-1 md:grid-cols-4 space-y-4 md:space-y-0 md:gap-2 py-2">
            <div class="py-2 px-2">
                <img class=" w-full aspect-video" src="{{asset('images/undraw_Travel.png')}}" alt="Hassle-Free" />
                <h3 class="font-bold text-2xl pb-2">Hassle-Free</h3>
                <span class=" text-lg leading-tight">We are dedicated to providing seamless and convenient travel experiences to our clients</span>
            </div>
            <div class="py-2 px-2">
                <img class=" w-full aspect-video" src="{{asset('images/undraw_Yacht.png')}}" alt="Service You Can Trust" />
                <h3 class="font-bold text-2xl pb-2">Service You Can Trust</h3>
                <span class=" text-lg leading-tight">We offer the most reliable and efficient transport options</span>
            </div>
            <div class="py-2 px-2">
                <img class=" w-full aspect-video" src="{{asset('images/undraw_adventure.png')}}" alt="Expertise" />
                <h3 class="font-bold text-2xl pb-2">Expertise</h3>
                <span class=" text-lg leading-tight">Our experts are here to help you plan your trip and make the most of your adventure</span>
            </div>
            <div class="py-2 px-2">
                <img class=" w-full aspect-video" src="{{asset('images/undraw_Trip.png')}}" alt="Get packages" />
                <h3 class="font-bold text-2xl pb-2">Get packages</h3>
                <span class=" text-lg leading-tight">Our tour packages are designed to offer a comprehensive and immersive travel experience</span>
            </div>
        </div>
    </div>

    <!-- popular packages -->
    <div class="w-full max-w-7xl mx-auto py-2 px-2">
        <div class="flex flex-col w-full mx-auto pt-10 pb-5">
            <div class="flex flex-row justify-between">
                <div class="text-3xl font-bold pb-1">Popular Tours</div>
                <div class="see-more-container mt-1">
                    <a href="{{ route('tour-packages.index') }}" class="inline-flex text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 items-center">
                        See More
                        <svg aria-hidden="true" class="w-5 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-2 px-1">
                @foreach($packages as $package)
                <div class="hover:-translate-y-2 ease-in duration-150 shadow first-letter:max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('tour-packages.show', $package) }}">
                        <img class="rounded-t-lg" src="{{asset( $package->cover_image )}}" alt="{{ $package->title }}" />
                    </a>
                    <div class="p-5">
                        <a href="{{ route('tour-packages.show', $package) }}">
                            <h5 class="mb-1 tracking-tight font-bold text-gray-900 line-clamp-1 dark:text-white">{{ $package->title }}</h5>
                        </a>
                        <span class="mb-3 py-1 px-2 text-xs font-bold rounded bg-gray-200 text-gray-700 dark:text-gray-400">Instant Confirmation</span>
                        <div class="pt-5">
                            From
                            <span class="text-base font-bold">Rp. {{ number_format($package->price, '0', ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="md:hidden w-full flex flex-row justify-center pt-2">
                <a href="{{ route('tour-packages.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">See More...</a>
            </div>
        </div>
    </div>

    <!-- best picture of the month -->
    <div class="w-full max-w-7xl mx-auto pt-10 px-2">
        <div class="flex flex-col">
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <div class="text-3xl font-bold">Best picture of the month</div>
                    <div class="text-gray-400">We have pictures based on location that they upload.</div>
                </div>
                <div class="see-more-container mt-1">
                    <a href="{{ route('page.gallery') }}" class="inline-flex text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 items-center">
                        See More
                        <svg aria-hidden="true" class="w-5 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="px-2 pt-2 grid grid-cols-1 gap-2 md:gap-4 md:grid-cols-3">
                @foreach($images as $image)
                    <div class="{{$image->show_on == 1 ? 'md:col-span-2 md:row-span-2' : ''}} transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0 scale-100 hover:scale-105 hover:z-10">
                        <img class="object-fill w-full {{$image->show_on == 1 ? 'h-auto' : 'h-full'}} rounded-lg" src="{{ $image->path_url }}" alt="{{ $image->name }}"/>
                        <div class="absolute px-4 text-xl {{$image->show_on == 1 ? 'md:text-4xl' : 'md:text-2xl'}} font-bold text-white bottom-10 md:left-10">
                            <p>{{ $image->name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="md:hidden w-full flex flex-row justify-center pt-2">
                <a href="{{ route('page.gallery') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">See More...</a>
            </div>
        </div>
    </div>

    <!-- latest updates -->
    <div class="w-full max-w-7xl mx-auto px-2">
        <div class="flex flex-col w-full mx-auto pt-10 pb-5 text-center md:text-left">
            <div class="flex flex-row justify-between">
                <div class="text-3xl font-bold pb-1">Lastest Updates</div>
                <div class="see-more-container">
                    <a href="{{ route('blog.index') }}" class="inline-flex text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 items-center">
                        See More
                        <svg aria-hidden="true" class="w-5 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-2 px-2">
                @foreach($posts as $post)
                <div class="hover:-translate-y-2 ease-in duration-150 shadow bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('blog.post', $post) }}">
                        <img class="rounded-t-lg" src="{{asset($post->cover_image)}}" alt="{{ $post->title }}" />
                    </a>
                    <div class="p-3 md:p-5 space-y-1">
                        <a href="{{ route('blog.post', $post) }}">
                            <h4 class="font-bold text-xl text-gray-900 dark:text-white line-clamp-1">{{ $post->title }}</h4>
                        </a>
                        <span class="line-clamp-1 text-sm text-gray-500">{{ $post->short_desc }}</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">
                                {{ $post->visitors_count }} views
                            </span>
                        </div>
                        <div>
                            @foreach($post->tags as $tag)
                                <span class="py-1 px-2 text-xs font-bold rounded bg-gray-200 text-gray-700 dark:text-gray-400">{{$tag->name}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="md:hidden w-full flex flex-row justify-center pt-2">
                <a href="{{ route('blog.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">See More...</a>
            </div>
        </div>
    </div>

    <!-- faq  -->
    <div class="w-full max-w-7xl mx-auto px-2 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col px-2">
                <div class="text-3xl text-center md:text-left font-bold md:text-4xl md:font-semibold pb-6">Frequently Asked Questions</div>
                <div class="relative md:w-4/5">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <form action="{{ route('page.faq') }}">
                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Topic's" required name="q"/>
                    </form>
                </div>
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
        </div>
    </div>
@endsection

