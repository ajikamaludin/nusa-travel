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

            <!-- Blog Post Header -->
            <section class="w-full max-w-7xl mx-auto">
                <img src="{{asset('images/2.jpg')}}" class="w-full h-96 rounded object-cover" alt="...">
            </section>

            <!-- Blog Post -->
            <section class="w-full mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-[1fr_4fr] gap-4 px-3 py-5 md:px-5 md:py-7">
                <div class="hidden md:block">
                    <div class="top-32 sticky z-[90] px-2 space-y-2">
                        <span class="text-gray-500 text-sm">Anda sedang membaca</span>
                        <h2 class="text-base leading-tight  font-bold">Sunrise overlooking Borobudur at Punthuk Setumbu Hil</h2>
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-300">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm text-gray-500">
                                (48 reviews) - 300+ booked
                            </span>
                        </div>
                    </div>
                </div>
                <div class=" space-y-2">
                    <!-- Breadcrumb -->
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2">
                            <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Home
                            </a>
                            </li>
                            <li>
                            <div class="flex items-center">
                                <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="#" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Blog</a>
                            </div>
                            </li>
                            <li aria-current="page">
                            <div class="flex items-center">
                                <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-bold text-gray-500 md:ml-2 dark:text-gray-400 line-clamp-1">Sunrise overlooking Borobudur at Punthuk Setumbu Hil</span>
                            </div>
                            </li>
                        </ol>
                    </nav>
                    <article class="space-y-4">
                        <h2 class="text-xl md:text-3xl leading-tight font-bold line-clamp-2">Sunrise overlooking Borobudur at Punthuk Setumbu Hil</h2>
                        <div>
                            <span class="px-1 text-gray-500 text-lg">18 Januari 2023</span>
                            <span class="px-1 text-blue-600 font-semibold text-lg">Jhon Doe</span>
                        </div>
                        <p class=" text-gray-600 text-sm">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolore excepturi ratione dolores exercitationem, porro cumque quam voluptatem molestiae vero nobis inventore, fuga explicabo. Possimus expedita suscipit atque ullam molestiae nisi harum consequatur soluta ipsum quae porro tempora veniam quis cum temporibus, architecto hic aspernatur. Animi, doloremque. Vitae nemo sed aspernatur doloribus libero nulla a fugit explicabo illum alias! Dolores modi ad quibusdam alias voluptate laborum distinctio ex iusto, vero pariatur quo praesentium quidem magni. Alias autem dolorem necessitatibus libero deleniti tempore dolor consequuntur? Magnam fugiat sed, autem in natus, aliquam accusantium, vel omnis illo deleniti cupiditate dicta nobis? Adipisci, accusantium corporis. Provident praesentium aperiam amet commodi, in non. Alias ut nisi distinctio tempora excepturi aliquid delectus officiis vero quas a eum suscipit placeat exercitationem blanditiis, quae veniam consequatur praesentium in nostrum ratione ipsam. Fugit ea illo, eveniet quo dolorem consectetur distinctio. Corporis, asperiores minima. Itaque inventore ipsam accusantium eos ex error culpa odit recusandae, distinctio optio, delectus explicabo, rerum molestiae vitae nihil. Magni odio voluptate repellat ex doloribus optio natus provident laudantium quia quis quam necessitatibus officiis dolorem accusantium ut nisi perferendis quisquam facere, recusandae omnis placeat soluta incidunt sit? Doloribus quas sunt minima voluptates quam. Non odio molestias nobis!</p>
                        <p class=" text-gray-600 text-sm">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolore excepturi ratione dolores exercitationem, porro cumque quam voluptatem molestiae vero nobis inventore, fuga explicabo. Possimus expedita suscipit atque ullam molestiae nisi harum consequatur soluta ipsum quae porro tempora veniam quis cum temporibus, architecto hic aspernatur. Animi, doloremque. Vitae nemo sed aspernatur doloribus libero nulla a fugit explicabo illum alias! Dolores modi ad quibusdam alias voluptate laborum distinctio ex iusto, vero pariatur quo praesentium quidem magni. Alias autem dolorem necessitatibus libero deleniti tempore dolor consequuntur? Magnam fugiat sed, autem in natus, aliquam accusantium, vel omnis illo deleniti cupiditate dicta nobis? Adipisci, accusantium corporis. Provident praesentium aperiam amet commodi, in non. Alias ut nisi distinctio tempora excepturi aliquid delectus officiis vero quas a eum suscipit placeat exercitationem blanditiis, quae veniam consequatur praesentium in nostrum ratione ipsam. Fugit ea illo, eveniet quo dolorem consectetur distinctio. Corporis, asperiores minima. Itaque inventore ipsam accusantium eos ex error culpa odit recusandae, distinctio optio, delectus explicabo, rerum molestiae vitae nihil. Magni odio voluptate repellat ex doloribus optio natus provident laudantium quia quis quam necessitatibus officiis dolorem accusantium ut nisi perferendis quisquam facere, recusandae omnis placeat soluta incidunt sit? Doloribus quas sunt minima voluptates quam. Non odio molestias nobis!</p>
                        <p class=" text-gray-600 text-sm">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolore excepturi ratione dolores exercitationem, porro cumque quam voluptatem molestiae vero nobis inventore, fuga explicabo. Possimus expedita suscipit atque ullam molestiae nisi harum consequatur soluta ipsum quae porro tempora veniam quis cum temporibus, architecto hic aspernatur. Animi, doloremque. Vitae nemo sed aspernatur doloribus libero nulla a fugit explicabo illum alias! Dolores modi ad quibusdam alias voluptate laborum distinctio ex iusto, vero pariatur quo praesentium quidem magni. Alias autem dolorem necessitatibus libero deleniti tempore dolor consequuntur? Magnam fugiat sed, autem in natus, aliquam accusantium, vel omnis illo deleniti cupiditate dicta nobis? Adipisci, accusantium corporis. Provident praesentium aperiam amet commodi, in non. Alias ut nisi distinctio tempora excepturi aliquid delectus officiis vero quas a eum suscipit placeat exercitationem blanditiis, quae veniam consequatur praesentium in nostrum ratione ipsam. Fugit ea illo, eveniet quo dolorem consectetur distinctio. Corporis, asperiores minima. Itaque inventore ipsam accusantium eos ex error culpa odit recusandae, distinctio optio, delectus explicabo, rerum molestiae vitae nihil. Magni odio voluptate repellat ex doloribus optio natus provident laudantium quia quis quam necessitatibus officiis dolorem accusantium ut nisi perferendis quisquam facere, recusandae omnis placeat soluta incidunt sit? Doloribus quas sunt minima voluptates quam. Non odio molestias nobis!</p>
                    </article>
                </div>
            </section>

            <!-- footer -->
            <div class="w-full bg-gray-100">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row w-full justify-between py-5 px-6 border-b-2">
                    <div class="flex-1">
                        <div class="text-lg md:text-3xl font-bold pb-2">About Us</div>
                        <div>
                            An Indonesia's leading provider of fast boat tickets, we offer the most reliable and
                            efficient transport options for island-hopping. Our main fast boat, the Ekajaya Fast Boat,
                            is equipped with modern facilities and offers a comfortable and safe journey to your
                            desired destination.
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-2">
                        <div class="md:px-2">
                            <div class="text-lg md:text-xl font-bold pb-2">Company</div>
                            <div><a href="#">About Us</a></div>
                            <div><a href="#">Blog</a></div>
                        </div>
                        <div class="md:px-2">
                            <div class="text-lg md:text-xl font-bold pb-2">Terms of use</div>
                            <div>Terms of service</div>
                            <div>Privacy Policy</div>
                            <div>Cookie Policy</div>
                            <div>Refund Policy</div>
                            <div>Disclaimer</div>
                        </div>
                        <div class="md:px-2">
                            <div class="text-lg md:text-xl font-bold pb-2">Products</div>
                            <div>Tour Travels</div>
                            <div>Fastboat</div>
                            <div>Car Rentals</div>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row w-full justify-between items-center py-5 px-6">
                    <div>
                        <img src="{{asset('logo-side.png')}}" class="h-5 w-auto"/>
                    </div>
                    <div class="py-2">
                        &copy; {{now()->format('Y')}} Nusa Travel. All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
