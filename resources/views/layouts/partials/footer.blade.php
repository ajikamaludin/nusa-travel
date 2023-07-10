<!-- footer -->
<div class="w-full bg-gray-100">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row w-full justify-between py-5 px-6 border-b-2">
        <div class="flex-1">
            <div class="text-lg md:text-3xl font-bold pb-2">{{ __('website.About Us')}}</div>
            <div>
                {{ $setting->getValue('G_SITE_ABOUT') }}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-2">
            <div class="md:px-2">
                <div class="text-lg md:text-xl font-bold pb-2">{{ __('website.Company')}}</div>
                <div><a href="{{ route('page.show', ['page' => 'aboutus']) }}" class="hover:text-blue-500">{{ __('website.About Us')}}</a></div>
                <div><a href="{{ route('blog.index') }}" class="hover:text-blue-500">{{ __('website.Blog')}}</a></div>
            </div>
            <div class="md:px-2">
                <div class="text-lg md:text-xl font-bold pb-2">{{__('website.Terms of use')}}</div>
                <div>
                    <a href="{{ route('page.show', ['page' => 'term-of-service']) }}" class="hover:text-blue-500">{{ __('website.Terms of service')}}</a>
                </div>
                <div><a href="{{ route('page.show', ['page' => 'privacy-policy']) }}" class="hover:text-blue-500">{{ __('website.Privacy Policy')}}</a></div>
                <div><a href="{{ route('page.show', ['page' => 'cookiepolicy']) }}" class="hover:text-blue-500">{{ __('website.Cookie Policy')}}</a></div>
                <div><a href="{{ route('page.show', ['page' => 'refundpolicy']) }}" class="hover:text-blue-500">{{ __('website.Refund Policy')}}</a></div>
                <div><a href="{{ route('page.show', ['page' => 'disclaimer']) }}" class="hover:text-blue-500">{{ __('website.Disclaimer')}}</a></div>
            </div>
            <div class="md:px-2">
                <div class="text-lg md:text-xl font-bold pb-2">{{ __('website.Products')}}</div>
                <div>
                    <a href="{{route('tour-packages.index')}}" class="hover:text-blue-500">{{ __('website.Tour Travels')}}</a>
                </div>
                <div>
                    <a href="{{route('car.index')}}" class="hover:text-blue-500">{{ __('website.Car Rentals')}}</a>
                </div>
                <div>
                    <a href="{{route('fastboat')}}" class="hover:text-blue-500">{{ __('website.Fastboat')}}</a>
                </div>
                <div>
                    <a href="{{route('ekajaya-fastboat')}}" class="hover:text-blue-500">{{ __('website.Ekajaya Fastboat')}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row w-full justify-between items-center py-5 px-6">
        <div>
            <img src="{{asset($setting->getValue('G_SITE_LOGO'))}}" class="h-5 w-auto" alt="company logo"/>
        </div>
        <div class="py-2">
            &copy; {{now()->format('Y')}} {{$setting->getValue('G_SITE_NAME')}}. {{ __('website.All Rights Reserved')}}.
        </div>
    </div>
</div>