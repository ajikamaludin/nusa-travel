<!-- footer -->
<div class="w-full bg-gray-100">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row w-full justify-between py-5 px-6 border-b-2">
        <div class="flex-1">
            <div class="text-lg md:text-3xl font-bold pb-2">About Us</div>
            <div>
                {{$setting->getValue('G_SITE_ABOUT')}}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-2">
            <div class="md:px-2">
                <div class="text-lg md:text-xl font-bold pb-2">Company</div>
                <div><a href="{{ route('page.show', ['page' => 'aboutus']) }}">About Us</a></div>
                <div><a href="{{ route('blog.index') }}">Blog</a></div>
            </div>
            <div class="md:px-2">
                <div class="text-lg md:text-xl font-bold pb-2">Terms of use</div>
                <div>
                    <a href="{{ route('page.show', ['page' => 'term-of-service']) }}">Terms of service</a>
                </div>
                <div><a href="{{ route('page.show', ['page' => 'privacy-policy']) }}">Privacy Policy</a></div>
                <div><a href="{{ route('page.show', ['page' => 'cookiepolicy']) }}">Cookie Policy</a></div>
                <div><a href="{{ route('page.show', ['page' => 'refundpolicy']) }}">Refund Policy</a></div>
                <div><a href="{{ route('page.show', ['page' => 'disclaimer']) }}">Disclaimer</a></div>
            </div>
            <div class="md:px-2">
                <div class="text-lg md:text-xl font-bold pb-2">Products</div>
                <div><a href="{{route('tour-packages.index')}}">Tour Travels</a></div>
                <div><a href="{{route('fastboat')}}">Fastboat</a></div>
                <div><a href="{{route('car.index')}}">Car Rentals</a></div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row w-full justify-between items-center py-5 px-6">
        <div>
            <img src="{{asset($setting->getValue('G_SITE_LOGO'))}}" class="h-5 w-auto" alt="company logo"/>
        </div>
        <div class="py-2">
            &copy; {{now()->format('Y')}} {{$setting->getValue('G_SITE_NAME')}}. All Rights Reserved.
        </div>
    </div>
</div>