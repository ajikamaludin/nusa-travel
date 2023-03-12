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
                {{ $view == 1 ? 'Fill In Details' : 'Review' }}
            </div>

            <!-- order -->
            <div class="w-full bg-blue-500 p-4">
                <div class="w-full overflow-x-auto flex flex-nowrap gap-2">
                    @foreach($carts as $cart)
                    <div class="{{ count($carts) == 1 ? 'w-full' : 'w-2/3 md:w-7/12' }} flex-none bg-white shadow-lg rounded-lg">
                        <div class="px-2 pt-2">
                            <div class="text-gray-500 text-xs"> 
                                {{ Carbon::parse($cart['date'])->format('d M y') }} 
                            </div>
                            <div class="font-bold py-2 flex flex-row gap-1 items-center">
                                <div>
                                    {{ $cart['track']->source->name }} 
                                </div>
                                <x-icon name="arrow-right" class="w-3 h-3" />
                                <div>
                                    {{ $cart['track']->destination->name }}
                                </div>
                            </div>
                            <div class="text-gray-500 text-xs">
                                {{ $cart['track']->arrival_time }} - {{ $cart['track']->departure_time }}
                            </div>
                            <div class="text-gray-500 text-xs font-bold">
                                {{ $cart['track']->group->fastboat->name }}
                            </div>
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

            @if($view == 1)
                <!-- detail -->
                <div class="w-full p-4 mt-4">
                    <div class="font-bold">
                        Contact Details
                    </div>
                    <div x-data="{ open: @entangle('showContact').defer  }">
                        <div x-show="!open" class="mt-2 shadow-md rounded-md flex flex-col items-center border-2 hover:bg-gray-100" >
                            <div class="w-full flex flex-row justify-between items-center py-2 px-4"  x-on:click="open = ! open" >
                                @if($validContact)
                                    <div class="flex flex-row items-center">
                                        <x-icon name="mail" class="w-5 h-5 mr-2" />
                                        <div class="flex flex-col">
                                            <p>{{ $contact['name'] }}</p>
                                            <p class="text-sm text-gray-400">{{ $contact['email'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-green-500">
                                        <x-icon name="check" class="w-5 h-5" />
                                    </div>
                                @else
                                    <div class="flex flex-row">
                                        <x-icon name="mail" class="w-5 h-5 mr-2" />
                                        Fill In Contact Details 
                                        <span class="text-red-500">*</span>
                                    </div>
                                    <div class="text-blue-500">
                                        <x-icon name="chevron-right" class="w-5 h-5" />
                                    </div>
                                @endif
                            </div>
                            @if($validContact)
                                <div class="w-full flex flex-row gap-2 items-center bg-gray-200 pt-2 px-4" wire:click="addContactToPerson">
                                    <x-icon name="plus-circle" class="w-5 h-5" />
                                    <div wire:loading.remove>
                                        Add as Traveler
                                    </div>
                                    <div wire:loading.delay.long>
                                        loading...
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div x-show="open" class="hadow-md rounded-md border-2 p-4">
                            <div class="mt-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="John Doe" wire:model.defer="contact.name" autocomplete="off"/>
                                @error('name') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="+184567887" wire:model.defer="contact.phone" autocomplete="off"/>
                                @error('phone') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nation</label>
                                <select id="nation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" wire:model.defer="contact.nation">
                                    <option value=""></option>
                                    <option value="WNA">WNA (Foreign Nationals)</option>
                                    <option value="WNI">WNI (Indonesian)</option>
                                </select>
                                @error('nation') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="national_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">National ID</label>
                                <input type="number" min="10" id="national_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" wire:model.defer="contact.national_id" autocomplete="off"/>
                                @error('national_id') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="text" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="user@mail.com" wire:model.defer="contact.email" autocomplete="off"/>
                                @error('email') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <button wire:click="saveContact" wire:loading.remove class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">
                                    Save
                                </button>
                                <div wire:loading.delay.long>
                                    loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- pessanger -->
                <div class="w-full p-4 pt-0">
                    <div class="font-bold">
                        Travelers Details
                    </div>
                    @foreach($persons as $i => $a) 
                    <div x-data="{ open: @entangle('showPerson_' . $i).defer }">
                        <div 
                            class="mt-2 shadow-md rounded-md flex py-2 px-4 justify-between border-2 hover:bg-gray-100" 
                            x-on:click="open = ! open" 
                            x-show="!open"
                        >
                            @if(count($persons[$i] ?? []) != 0)
                            <div class="flex flex-row">
                                <x-icon name="user" class="w-5 h-5 mr-2" />
                                {{$persons[$i]['name']}}
                            </div>
                            <div class="text-green-500">
                                <x-icon name="check" class="w-5 h-5" />
                            </div>
                            @else
                            <div class="flex flex-row">
                                <x-icon name="user" class="w-5 h-5 mr-2" />
                                Person {{ $i + 1 }}
                                <span class="text-red-500">*</span>
                            </div>
                            <div class="text-blue-500">
                                <x-icon name="chevron-right" class="w-5 h-5" />
                            </div>
                            @endif
                        </div>
                        <div x-show="open" class="hadow-md rounded-md border-2 p-4">
                            <div class="mt-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="John Doe" wire:model.defer="persons.{{$i}}.name" autocomplete="off">
                                @error('name') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nation</label>
                                <select id="nation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" wire:model.defer="persons.{{$i}}.nation">
                                    <option value=""></option>
                                    <option value="WNA">WNA (Foreign Nationals)</option>
                                    <option value="WNI">WNI (Indonesian)</option>
                                </select>
                                @error('nation') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="national_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">National ID</label>
                                <input type="number" min="10" id="national_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" wire:model.defer="persons.{{$i}}.national_id" autocomplete="off">
                                @error('national_id') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <button wire:click="saveTraveler({{$i}})" wire:loading.remove class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">
                                    Save
                                </button>
                                <div wire:loading.delay.long>
                                    loading...
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- dropoffs -->
                <div class="w-full p-4 pt-0">
                    <div class="font-bold">
                        Dropoff (Optional)
                    </div>
                    <x-select
                        wire:model="dropoff"
                        placeholder="Dropoff"
                        :options="$dropoffs"
                        :min-items-for-search="5"
                        :clearable="true"
                        option-label="name"
                        option-value="name"
                        name="from"
                        required="true"
                        autocomplate="off"
                        right-icon="location-marker"
                    />
                </div>

                <!-- continue button -->
                <div class="w-full text-center" wire:loading.delay.long>
                    loading...
                </div>

                @if($isAllValid)
                <div wire:loading.remove>
                    <div 
                        class="mx-4 my-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                        wire:click="continue"
                    >
                        Continue
                    </div>
                </div>
                @endif
            @endif
        
            @if($view == 2)
                <!-- pessanger -->
                <div class="w-full p-4">
                    <div class="font-bold">
                        Passengers
                    </div>
                    @foreach($persons as $person)
                    <div class="bg-white flex flex-col border-b-2 p-1">
                        <span>{{ $person['name'] }}</span>
                        <span class="text-sm text-gray-400"> {{ $person['nation'] .' - '. $person['national_id'] }} </span>
                    </div>
                    @endforeach

                    @if($dropoff != '')
                    <div class="bg-white flex flex-row p-1 justify-between">
                        <span class="flex flex-row gap-1 items-center font-light text-gray-400">
                            Dropoff: {{ $dropoff }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- price details -->
                <div class="w-full p-4">
                    <div class="font-bold">
                        Price Details
                    </div>
                    @foreach($carts as $cart)
                        <div class="bg-white flex flex-row border-b-2 p-1 justify-between">
                            <span class="flex flex-row gap-1 items-center">
                                {{ $cart['track']->source->name  }} 
                                <x-icon name="arrow-right" class="w-3 h-3" />
                                {{ $cart['track']->destination->name  }}
                            </span>
                            <span> x {{ $cart['qty'] }} </span>
                            <span> {{ number_format($cart['qty'] * $cart['track']->price, 0, ',' , '.') }} </span>
                        </div>
                    @endforeach

                    @if($discount != 0)
                        <div class="bg-white flex flex-row border-b-2 p-1 justify-between">
                            <span class="flex flex-row gap-1 items-center">
                                Discount
                            </span>
                            <span> -{{ number_format($total, 0, ',' , '.') }} </span>
                        </div>
                    @endif

                    <div class="bg-white flex flex-row border-b-2 p-1 justify-between font-bold">
                        <span class="flex flex-row gap-1 items-center">
                            Total
                        </span>
                        <span> {{ number_format($total, 0, ',' , '.') }} </span>
                    </div>

                    @if(count($promos) > 0)
                    <div class="p-4 my-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                        <span class="font-medium">Promo aplied!</span> 
                        <div>Promo Abc</div>
                        <div>Promo DEF</div>
                    </div>
                    @endif
                </div>

                <div wire:loading.remove class="mx-4">
                    <button 
                        class="w-full text-left mt-4 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                        wire:click="payment"
                    >
                        Proccess Payment
                    </button>
                </div>
                <div class="px-4 text-sm text-gray-400">
                    By clicking the Payment button. you agree to the 
                    <a href="{{ route('page.show', ['page' => 'term-of-service']) }}" target="_blank" class="text-blue-500">Terms and Conditions </a>
                    and 
                    <a href="{{ route('page.show', ['page' => 'privacy-policy']) }}" target="_blank" class="text-blue-500">Privacy and Policy</a>
                </div>
            @endif

            <div class="p-4"></div>
        </div>
    </div>
</x-modal>
