<div class="w-full mx-auto max-w-7xl px-2 py-5">
    <x-dialog z-index="z-50" blur="md" align="center" />
    <div class="mx-auto p-6 flex flex-col">
        <div class="font-bold text-3xl mb-5">{{ __('website.Order')}} #</div>
        <div class="w-full flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-3/4">
                <div class="flex flex-col gap-4">
                    @foreach($carts as $cart)
                    <div class="flex flex-col shadow-lg px-4 py-2 border-2 rounded-md">
                        <div class="flex flex-row justify-between border-b-2">
                            <div class="font-bold">
                                {!! $cart['detail'] !!}
                            </div>

                            <div class="flex flex-row justify-end gap-2 items-center">
                                <div class="text-gray-700 hover:text-gray-500" wire:click="incrementQty('{{$cart['id']}}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    {{$cart['qty']}}
                                </div>
                                <div class="text-gray-700 hover:text-gray-500" wire:click="decrementQty('{{$cart['id']}}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between py-2">
                            <div class="text-red-700 hover:text-red-400" wire:click="removeItem('{{ $cart['id'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>

                            </div>
                            <div class="font-bold">
                                {{ number_format($cart['price'] * $cart['qty'], '0', ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="w-full lg:flex-1">
                <div class="shadow-lg p-4 border-2 rounded-lg">
                        @if($isFastboat)
                            <div class="w-full flex">
                                <a href="{{ route('customer.cart.fastboat') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full text-center">{{ __('website.Process Order Fastboat')}}</a>
                            </div>
                            <div class="mt-2">
                                <p class="italic text-xs">please remove fastboat items, if you want to proccess other orders</p>
                            </div>
                        @else
                        <form wire:submit.prevent="submit">
                            @if(!$isAuth)
                                <div class="mb-5">
                                    <div class="mt-2">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Name')}}</label>
                                        <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('website.Name')}}" wire:model.defer="name" autocomplete="off">
                                        @error('name') 
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mt-2">
                                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Phone Number')}}</label>
                                        <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+184567887" wire:model.defer="phone" autocomplete="off">
                                        @error('phone') 
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Nation')}}</label>
                                        <select id="nation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="nation">
                                            <option value=""></option>
                                            <option value="WNA">WNA (Foreign Nationals)</option>
                                            <option value="WNI">WNI (Indonesian)</option>
                                        </select>
                                        @error('nation') 
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label for="national_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.National ID')}}</label>
                                        <input type="number" min="10" id="national_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" wire:model.defer="national_id" autocomplete="off">
                                        @error('national_id') 
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('website.Email')}}</label>
                                        <input type="text" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="user@mail.com" wire:model.defer="email" autocomplete="off">
                                        @error('email') 
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            
                            @if(count($payments) > 1)
                                <h2 class="font-bold mb-2">Payment Options</h2>
                                <div class="flex flex-col justify-between space-y-2">
                                @foreach($payments as $index => $payment)
                                    <div class="flex flex-row justify-between items-center space-x-1 p-2 px-4 border shadow rounded min-h-[75px]" wire:click="setSelectedPayment({{ $index }})">
                                        <input type="radio" name="payment" value="{{ $payment['name'] }}" {{ $payment['name'] == $selectedPayment['name'] ? 'checked' : '' }}/>
                                        @if($payment['logo'] != null) 
                                            <img src="{{ $payment['logo'] }}" class="object-fill w-[80%]" alt="{{ $payment['name'] }}"/>
                                        @else
                                            <p class="font-bold">{{ $payment['display_name'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                                </div>
                            @endif
                            
                            <div class="font-bold text-xl mt-5">{{ __('website.Total')}} : {{ number_format($total, '0', ',', '.') }}</div>
                            <div class="w-full flex my-5 ">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">{{ __('website.Process Payment')}}</button>
                            </div>
                        </form>
                        @endif
                    
                </div>
            </div>
            </div>
    </div>
</div>