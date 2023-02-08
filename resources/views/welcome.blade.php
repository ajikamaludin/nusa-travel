<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @vite(['resources/js/app.jsx'])

    </head>
    <body class="antialiased">
        <div class="w-full justify-center flex flex-col">
            <div class="sticky top-0 z-50 bg-white">
                <!-- Header -->
                <div class="flex flex-row border-b-2 border-gray-100 pt-4 pb-2 px-2 lg:px-10">
                    <div class="flex flex-row max-w-7xl mx-auto w-full justify-between items-center ">
                        <div class="flex items-center">
                            <img src="{{asset('logo-side.png')}}" class="h-10 w-auto"/>
                        </div>
                        <div class="flex flex-row gap-1 items-center">
                            <div class="px-2.5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 flex flex-row gap-2">
                                <img src="{{asset('images/flag_usa.png')}}" class="h-3 w-auto" alt="nation"/>
                                <img src="{{asset('images/chevron_down.svg')}}" class="h-2 w-auto" alt="chevron-down"/>
                            </div>
                            <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">Sign Up</button>
                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
                        </div>
                    </div>
                </div>
                <!-- Menu -->
                <div class="flex flex-row gap-2 items-center border-b-2 border-gray-100 px-2 lg:px-16 overflow-auto">
                    <div class="flex flex-row max-w-7xl mx-auto w-full items-center font-bold">
                        <div class="my-1 px-4 py-2 text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Home
                        </div>
                        <div class="my-1 px-4 py-2 text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Tour Packages
                        </div>
                        <div class="my-1 px-4 py-2 text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Fastboat
                        </div>
                        <div class="my-1 px-4 py-2 text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Car Rentals
                        </div>
                        <div class="my-1 px-4 py-2 text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Blog
                        </div>
                        <div class="my-1 px-4 py-2 text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            FAQ
                        </div>
                        <div class="my-1 px-4 py-2 text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            About Us
                        </div>
                    </div>
                </div>
            </div>
            <!-- C -->
            <div class="w-full mx-auto">
                <div id="animation-carousel" class="relative" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-72 overflow-hidden md:h-99" >
                        <!-- Item 1 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <span class="absolute text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 sm:text-3xl dark:text-gray-800">First Slide</span>
                            <img src="{{asset('images/1.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                        </div>
                        <!-- Item 2 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{asset('images/2.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                        </div>
                        <!-- Item 3 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{asset('images/3.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                        </div>
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
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

                    <div class="hidden md:block absolute z-40 -bottom-10 left-1/2 -translate-x-1/2 w-full lg:w-2/3 mx-auto h-60 ">
                        <div>
                            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                                <li class="">
                                    <a href="#" aria-current="page" class="inline-block p-3 font-bold bg-blue-600 text-white rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Fastboat</a>
                                </li>
                                <li class="">
                                    <a href="#" class="inline-block p-3 font-bold rounded-t-lg bg-gray-100 hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Car Rentals</a>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-white rounded-b-lg rounded-r-lg border-gray-200 shadow-lg px-8 py-6">
                            <div class="flex flex-row w-full ">
                                <ul class="items-center w-1/2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="horizontal-list-radio-license" type="radio" value="" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" checked>
                                            <label for="horizontal-list-radio-license" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">One way </label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center pl-3">
                                            <input id="horizontal-list-radio-id" type="radio" value="" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-id" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Round Trip</label>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="grid grid-cols-3 pt-4 gap-2">
                                <div>
                                    <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="From" required>
                                </div>
                                <div>
                                    <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="To" required>
                                </div>
                                <div>
                                    <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date" required>
                                </div>
                            </div>  
                            <div class="w-full flex flex-row justify-end pt-2">
                                <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- mobile order -->
            <div class="w-full max-w-7xl mx-auto pt-5">
                <div class="md:hidden block w-full mx-auto">
                    <div>
                        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                            <li class="">
                                <a href="#" aria-current="page" class="inline-block p-3 font-bold bg-blue-600 text-white rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Fastboat</a>
                            </li>
                            <li class="">
                                <a href="#" class="inline-block p-3 font-bold rounded-t-lg bg-gray-100 hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Car Rentals</a>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white rounded-b-lg rounded-r-lg border-gray-200 shadow-lg px-8 py-6">
                        <div class="flex flex-row w-full ">
                            <ul class="grid w-full gap-1 grid-cols-2">
                                <li>
                                    <input type="radio" checked id="hosting-small" name="hosting" value="hosting-small" class="hidden peer" required>
                                    <label for="hosting-small" class="inline-flex items-center justify-between w-full px-5 py-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                        <div class="block">
                                            <div class="w-full text-base font-semibold">One Way</div>
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="hosting-big" name="hosting" value="hosting-big" class="hidden peer" required>
                                    <label for="hosting-big" class="inline-flex items-center justify-between w-full px-5 py-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                                        <div class="block">
                                            <div class="w-full text-base font-semibold">Round Trip</div>
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="grid grid-cols-1 pt-4 gap-2">
                            <div>
                                <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="From" required>
                            </div>
                            <div>
                                <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="To" required>
                            </div>
                            <div>
                                <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Date" required>
                            </div>
                        </div>  
                        <div class="w-full flex flex-row justify-end pt-2">
                            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- popular packages -->
            <div class="w-full max-w-7xl mx-auto pt-10 px-2">
                <div class="flex flex-col w-full mx-auto pt-10 pb-5 text-center md:text-left">
                    <div class="text-2xl font-bold">Popular Tours</div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-2 px-1">
                        @foreach([1,2,3,4] as $a)
                        <div class="hover:-translate-y-2 ease-in duration-100 first-letter:max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <img class="rounded-t-lg" src="{{asset('images/1.jpg')}}" alt="" />
                            </a>
                            <div class="p-5">
                                <a href="#">
                                    <h5 class="mb-1 tracking-tight font-bold text-gray-900 dark:text-white">Sunrise overlooking Borobudur at Punthuk Setumbu Hil...</h5>
                                </a>
                                <span class="mb-3 py-1 px-2 text-xs font-bold rounded bg-gray-200 text-gray-700 dark:text-gray-400">Instant Confirmation</span>
                                <div class="pt-5">
                                    From 
                                    <span class="text-base font-bold">Rp 562.000</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="w-full flex flex-row justify-center pt-2">
                        <div type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">See More...</div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-7xl mx-auto pt-10 px-2">
                <div class="flex flex-col">
                    <div class="flex flex-row justify-between">
                        <div class="flex flex-col">
                            <div class="text-2xl font-bold">Best picture of the month</div>
                            <div class="text-gray-400">We have pictures based on location that they upload.</div>
                        </div>
                        <div>
                            <div type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">See More</div>
                        </div>
                    </div>
                    <div class="px-2 pt-2 flex flex-row">
                        <div class="relative w-2/3 transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0 scale-100 hover:scale-110 hover:z-10">
                            <img class="object-fill w-full h-auto rounded-lg" src="{{asset('images/4.jpg')}}" alt=""/>
                            <div class="absolute px-4 text-xl md:text-4xl font-bold text-white bottom-10 md:left-10">
                                <p>Pantai Indah Kapuk</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 pl-2 w-1/3">
                            @foreach([1,2] as $a)
                                <div class="relative transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0 scale-100 hover:scale-110 hover:z-10">
                                    <img class="object-fill h-full w-full rounded-lg" src='{{asset("images/$a.jpg")}}' alt=""/>
                                    <div class="absolute px-4 text-xl md:text-2xl font-bold text-white bottom-10 md:left-5">
                                        <p>Selat Duri {{ $a }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- latest updates -->
            <div class="w-full max-w-7xl mx-auto px-2">
                <div class="flex flex-col w-full mx-auto pt-10 pb-5 text-center md:text-left">
                    <div class="text-2xl font-bold">Lastest Updates</div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-2 px-2">
                        @foreach([1,2,3,4] as $a)
                        <div class="hover:-translate-y-2 ease-in duration-100 first-letter:max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <img class="rounded-t-lg" src="{{asset('images/1.jpg')}}" alt="" />
                            </a>
                            <div class="p-5">
                                <a href="#">
                                    <h5 class="mb-1 tracking-tight font-bold text-gray-900 dark:text-white">Sunrise overlooking Borobudur at Punthuk Setumbu Hil...</h5>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="w-full flex flex-row justify-center pt-2">
                        <div type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">See More...</div>
                    </div>
                </div>
            </div>

            <!-- TODO: tambah FAQ seperti yang di gambar design  -->

            <!-- TODO: ganti mirip seperti yang di gambar design -->
            <!-- footer -->
            <div class="w-full bg-gray-100">
                <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 w-full justify-between  py-5 px-16">
                    <div>
                        &copy; {{now()->format('Y')}} Nusa Travel. All Rights Reserved.
                    </div>
                    <div>
                        <div class="font-bold pb-2">About</div>
                        <div><a href="#">About Us</a></div>
                        <div><a href="#">Blog</a></div>
                    </div>
                    <div>
                        <div class="font-bold pb-2">Terms of use</div>
                        <div>Terms of service</div>
                        <div>Privacy Policy</div>
                        <div>Cookie Policy</div>
                        <div>Refund Policy</div>
                        <div>Disclaimer</div>
                    </div>
                    <div>
                        <div class="font-bold pb-2">Payment channels</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
