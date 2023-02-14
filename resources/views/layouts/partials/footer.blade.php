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