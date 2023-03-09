<x-modal 
    blur 
    name="myModal"
    wire:model="show"
    spacing="p-0"
    align="center"
    x-on:close="$openModal('myModal')"
>
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow items-center h-full md:h-auto">
            <!-- header -->
            <div class="flex  items-center justify-center p-4 rounded-t bg-blue-500 text-white">
                Fill In Details
            </div>
            <div class="w-full bg-blue-500 p-4">
            <!-- order -->
            <div class="w-full overflow-x-auto flex flex-nowrap gap-2">
                @foreach($carts as $cart)
                <div class="w-2/3 md:w-7/12 flex-none bg-white shadow-lg rounded-lg">
                    <div class="px-2 pt-2">
                        <div class="text-gray-500 text-xs">{{ $cart['date'] }}</div>
                        <div class="font-bold py-2 flex flex-row gap-1 items-center">
                            <div>{{ $cart['track']->source->name }} </div>
                            <x-icon name="arrow-right" class="w-3 h-3" />
                            <div>{{ $cart['track']->destination->name }}</div>
                        </div>
                        <div class="text-gray-500 text-xs">
                            {{ $cart['track']->arrival_time }} - {{ $cart['track']->departure_time }}
                        </div>
                        <div class="text-gray-500 text-xs font-bold">{{ $cart['track']->group->fastboat->name }}</div>
                    </div>
                    <div class="bg-gray-200 p-2 rounded-b-lg">
                        Rp {{ number_format($cart['track']->price, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
            </div>
            @guest('customer')
            <!-- login support -->
            <a href="{{ route('customer.login') }}" class="w-full shadow-md flex flex-row px-6 py-2 items-center justify-between">
                <div>
                    <div class="text-base font-bold">Log in or Register</div>
                    <div class="text-xs text-gray-500">To book faster, log in now!</div>
                </div>
                <div class="text-blue-500">
                    <x-icon name="chevron-right" class="w-5 h-5" />
                </div>
            </a>
            @endguest

            <!-- detail -->
            <div class="w-full p-4 mt-4">
                <div class="font-bold">
                    Contact Details
                </div>
                <div class="mt-2 shadow-md rounded-md flex py-2 px-4 justify-between border-2 hover:scale-95">
                    <div class="flex flex-row">
                        <x-icon name="mail" class="w-5 h-5 mr-2" />
                        Fill In Contact Details 
                        <span class="text-red-500">*</span>
                    </div>
                    <div class="text-blue-500">
                        <x-icon name="chevron-right" class="w-5 h-5" />
                    </div>
                </div>
            </div>

            <!-- pessanger -->
            <div class="w-full p-4 pt-0">
                <div class="font-bold">
                    Travelers Details
                </div>
                @foreach(range(0, $cart['qty']) as $i => $a) 
                <div class="mt-2 shadow-md rounded-md flex py-2 px-4 justify-between border-2 hover:scale-95">
                    <div class="flex flex-row">
                        <x-icon name="user" class="w-5 h-5 mr-2" />
                        Person {{ $i + 1 }}
                        <span class="text-red-500">*</span>
                    </div>
                    <div class="text-blue-500">
                        <x-icon name="chevron-right" class="w-5 h-5" />
                    </div>
                </div>
                @endforeach
            </div>

            <!-- continue button -->
            <div 
                class="mx-4 my-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 "
            >
                Continue
            </div>
            <div class="p-4"></div>
        </div>
    </div>
</x-modal>
