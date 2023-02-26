<div class="w-full p-4 shadow-lg border-2 rounded-lg">
    @if($quantity >= 1)
    <div class="text-2xl font-bold w-full text-center mb-2">
        Total: IDR {{ number_format($total, '0', ',', '.') }}
    </div>
    <div class="flex flex-row justify-around text-2xl gap-2 items-center">
        <div class="text-gray-700 hover:text-gray-500" wire:click="increment">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            {{ $quantity }}
        </div>
        <div class="text-gray-700 hover:text-gray-500" wire:click="decrement">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    <button class="mt-5 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5" wire:click="checkout">Checkout</button>
    @else
    <div class="w-full flex flex-col gap-2 justify-center">
        <input type="date" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Date" required autocomplete="off" name="date" wire:model.defer="date" min="{{ now()->format('Y-m-d') }}">
        <button class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5" wire:click="addCart">Order</button>
    </div>
    @endif
</div>