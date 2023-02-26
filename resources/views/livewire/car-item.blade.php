<div class="px-6 py-4 mb-1 shadow items-center flex flex-col md:flex-row border-2 border-gray-200 rounded scale-100 hover:scale-105 hover:z-50">
    <div class="flex md:w-1/6 mx-2">
        <img src="{{ $car->image_url }}" alt="{{ $car->name }}"/>
    </div>
    <div class="flex flex-col md:w-5/6">
        <div class="w-full flex flex-row justify-between">
            <div class="flex flex-row gap-5 justify-around md:w-3/6">
                <div class="flex flex-col">
                    <p class="font-bold text-xl">{{ $car->name }}</p>
                    <p>{{ $car->description }} </p>
                </div>
            </div>
            <div class="flex flex-col items-end md:w-2/6  gap-3">
                <p class="font-bold text-xl">{{ number_format($car->price, 0, ',', '.') }}</p>
                <div class="flex flex-row gap-2 justify-end">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 add" wire:click="addCart" wire:loading.remove>Order</button>
                    <div wire:loading.delay.long>
                        adding...
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-row justify-end mt-2">
            <p class="text-sm text-gray-600 "><span class="font-medium">Seats: {{ $car->capacity}} | </p>
            <p class="text-sm text-gray-600 "><span class="font-medium">Luggage: {{ $car->luggage }} | </p>
            <p class="text-sm text-gray-600 "><span class="font-medium">Transmision: {{ $car->transmission }}</p>
        </div>
    </div>
</div>