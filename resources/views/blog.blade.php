<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nusa Travel</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @vite(['resources/js/frontpage.jsx'])
    </head>
    <body class="antialiased">
        <div class="w-full justify-center flex flex-col">
            <!-- header -->
            <div class="sticky top-0 z-50 shadow bg-white">
                <!-- Header -->
                <div class="flex flex-row border-b-2 border-gray-100 pt-4 pb-2 px-2 lg:px-10">
                    <div class="flex flex-row max-w-7xl mx-auto w-full justify-between items-center ">
                        <div class="flex items-center">
                            <img src="{{asset('logo-side.png')}}" class="h-10 w-auto"/>
                        </div>
                        <div class="hidden md:flex flex-row gap-1 items-center">
                            <div id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="px-2.5 py-2.5 cursor-pointer text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 flex flex-row gap-2">
                                <img src="{{asset('images/flag_usa.png')}}" class="h-3 w-auto" alt="nation"/>
                                <img src="{{asset('images/chevron_down.svg')}}" class="h-2 w-auto" alt="chevron-down"/>
                            </div>
                            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <a href="#" class="inline-flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white gap-1">
                                            <img src="{{asset('images/flag_indonesia.png')}}" class="h-3 w-4" alt="nation"/>
                                            <p>Indonesia</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="inline-flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white gap-1">
                                            <img src="{{asset('images/flag_usa.png')}}" class="h-3 w-4" alt="nation"/>
                                            <p>English</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <button type="button" class="px-5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">Sign Up</button>

                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
                        </div>

                        <div class="space-y-2 md:hidden" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation" aria-controls="drawer-navigation">
                            <span class="block w-8 h-0.5 bg-gray-600"></span>
                            <span class="block w-8 h-0.5 bg-gray-600"></span>
                            <span class="block w-5 h-0.5 bg-gray-600"></span>
                        </div>
                    </div>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex flex-row gap-2 items-center border-b-2 border-gray-100 px-2 lg:px-16 overflow-auto">
                    <div class="flex flex-row max-w-7xl mx-auto w-full items-center font-bold">
                        <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Home
                        </div>
                        <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Tour Packages
                        </div>
                        <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Fastboat
                        </div>
                        <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Car Rentals
                        </div>
                        <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            Blog
                        </div>
                        <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            FAQ
                        </div>
                        <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            About Us
                        </div>
                    </div>
                </div>
            </div>

            <!-- drawer -->
            <div id="drawer-navigation" class="fixed top-0 left-0 z-50 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-full dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
                <img src="{{asset('logo-side.png')}}" class="h-10 w-auto"/>
                <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close menu</span>
                </button>
                <div class="py-4 overflow-y-auto">
                    <ul>
                        <li>
                            <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="ml-3">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="ml-3">Tour Packages</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="ml-3">Fastboat</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="ml-3">Car Rentals</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="ml-3">Blog</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="ml-3">FAQ</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="ml-3">About us</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Hero Blog -->
            <section class="w-full max-w-7xl mx-auto min-h-[250px] relative flex flex-col items-center justify-center">
                <img src="{{asset('images/2.jpg')}}" class="w-full brightness-75  h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
                <div class="relative text-white text-center space-y-2">
                    <h1 class=" text-4xl md:text-6xl font-semibold">Blogs</h1>
                    <p class="text-base md:text-lg">Explore knowledge, tours and more</p>
                </div>
            </section>

            <!-- Blog  -->
            <section class="w-full mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-4 gap-4 py-2 md:py-5 px-1">
                @foreach([1,2,3,4,5,6,7,8] as $a)
                <div class="hover:-translate-y-2 ease-in duration-150 shadow bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" src="{{asset('images/1.jpg')}}" alt="" />
                    </a>
                    <div class="p-3 md:p-5 space-y-1">
                        <span class=" text-gray-500 text-sm">
                            Yogyakarta - tours
                        </span>
                        <a href="#">
                            <h4 class="font-bold text-xl text-gray-900 dark:text-white line-clamp-1">Sunrise overlooking Borobudur at Punthuk Setumbu Hil</h4>
                        </a>
                        <span class="line-clamp-1 text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, velit.</span>
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-300">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm text-gray-500">
                                (48 reviews) - 300+ booked
                            </span>
                        </div>
                        <div>
                            <span class="py-1 px-2 text-xs font-bold rounded bg-gray-200 text-gray-700 dark:text-gray-400">Instant Confirmation</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </section>
        </div>
    </body>
</html>
