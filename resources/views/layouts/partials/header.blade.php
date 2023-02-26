<!-- header -->
<div class="sticky top-0 z-50 shadow bg-white">
    <!-- Header -->
    <div class="flex flex-row border-b-2 border-gray-100 pt-4 pb-2 px-2 lg:px-10">
        <div class="flex flex-row max-w-7xl mx-auto w-full justify-between items-center ">
            <a href="{{ route('home.index') }}" class="flex items-center">
                <img src="{{ asset($setting->getValue('G_SITE_LOGO')) }}" class="h-10 w-auto"/>
            </a>
            <div class="lang-container flex-row gap-1 items-center">
                <div>
                    <div id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="px-2.5 py-2.5 cursor-pointer text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white flex flex-row gap-2 items-center">
                        @if(session('locale') == 'en')
                        <img src="{{asset('images/flag_usa.png')}}" class="h-3 w-auto" alt="nation"/>
                        @else
                        <img src="{{asset('images/flag_indonesia.png')}}" class="h-3 w-auto" alt="nation"/>
                        @endif
                        <div>{{ session('locale') }}</div>
                        <img src="{{asset('images/chevron_down.svg')}}" class="h-2 w-auto" alt="chevron-down"/>
                    </div>
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="{{ route('home.index') }}/id" class="inline-flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white gap-1">
                                    <img src="{{asset('images/flag_indonesia.png')}}" class="h-3 w-4" alt="nation"/>
                                    <p>Indonesia</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home.index') }}/en" class="inline-flex w-full items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white gap-1">
                                    <img src="{{asset('images/flag_usa.png')}}" class="h-3 w-4" alt="nation"/>
                                    <p>English</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(auth()->check())
                <button id="dropdownUser" data-dropdown-toggle="dropdownuser" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button"> {{ auth()->user()->name }} <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                <!-- Dropdown menu -->
                <div id="dropdownuser" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownUser">
                    <li>
                        <a href="{{ route('customer.profile') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('customer.orders') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Order</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('customer.logout') }}" id='form-logout'>
                            @csrf
                            <input type="hidden" name="">
                            <a href="#" onclick="document.getElementById('form-logout').submit()" type="submit" class="block px-4 py-2 hover:bg-gray-100">{{__('website.Logout')}}</a>
                        </form>
                    </li>
                    </ul>
                </div>

                @else
                <a href="{{ route('customer.signup') }}" class="px-5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">{{__('website.Sign Up')}}</a>
                <a href="{{ route('customer.login') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{__('website.Login')}}</a>
                @endif
            </div>

            <div class="space-y-2 md:hidden" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation" aria-controls="drawer-navigation">
                <span class="block w-8 h-0.5 bg-gray-600"></span>
                <span class="block w-8 h-0.5 bg-gray-600"></span>
                <span class="block w-5 h-0.5 bg-gray-600"></span>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <div class="menu-container flex-row gap-2 items-center border-b-2 border-gray-100 px-2 lg:px-16 overflow-auto">
        <div class="flex flex-row max-w-7xl mx-auto w-full items-center font-bold">
            <a href="{{ route('home.index') }}" class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">
                Home
            </a>
            <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">
                Tour Packages
            </div>
            <a href="{{ route('fastboat.index') }}" class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">
                Fastboat
            </a>
            <div class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">
                Car Rentals
            </div>
            <a href="{{ route('blog.index') }}" class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">
                Blog
            </a>
            <a href="{{ route('page.faq') }}" class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">
                FAQ
            </a>
            <a href="{{ route('page.show', ['page' => 'aboutus']) }}" class="my-1 px-4 py-2 cursor-pointer rounded text-sm text-gray-900 focus:outline-none bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white">
                About Us
            </a>
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
                <a href="{{ route('home.index') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                <span class="ml-3">Tour Packages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('fastboat.index') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                <span class="ml-3">Fastboat</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                <span class="ml-3">Car Rentals</span>
                </a>
            </li>
            <li>
                <a href="{{ route('blog.index') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                <span class="ml-3">Blog</span>
                </a>
            </li>
            <li>
                <a href="{{ route('page.faq') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                <span class="ml-3">FAQ</span>
                </a>
            </li>
            <li>
                <a href="{{ route('page.show', ['page' => 'aboutus']) }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                <span class="ml-3">About us</span>
                </a>
            </li>
            <li>
                @guest
                <div class="grid grid-cols-2">
                    <a href="{{ route('customer.signup') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 border-2">
                    <span class="ml-3">{{ __('website.Sign Up') }}</span>
                    </a>
                    <a href="{{ route('customer.login') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 border-2">
                    <span class="ml-3">{{ __('website.Login') }}</span>
                    </a>
                </div>
                @endguest
                @auth
                <div class="grid grid-cols-2">
                    <a href="{{ route('customer.profile') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 border-2">
                        <span class="ml-3">{{ __('website.Logout') }}</span>
                    </a>
                    <a href="{{ route('customer.orders') }}" class="flex items-center py-4 px-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 border-2">
                        <span class="ml-3">{{ 'Order' }}</span>
                    </a>
                </div>
                @endauth
            </li>
        </ul>
    </div>
</div>

