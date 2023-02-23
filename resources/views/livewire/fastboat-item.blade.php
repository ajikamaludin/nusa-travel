<div class="px-6 py-4 mb-1 shadow items-center grid grid-cols-2 border-2 border-gray-200 rounded scale-100 hover:scale-110">
    <div class="flex flex-row gap-5 justify-around">
        <div class="flex flex-col">
            <p class="font-bold">{{ $track->source->name }}</p>
            <p>{{ $track->arrival_time }} </p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
        </svg>
        <div>
            <p class="font-bold">{{ $track->destination->name }}</p>
            <p>{{ $track->departure_time }} </p>
        </div>
    </div>
    <div class="flex flex-col items-end w-full mr-10 gap-3">
        <p class="font-bold text-xl">{{ number_format($track->price, 0, ',', '.') }}</p>
            <div class="flex flex-row gap-2 justify-end">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 add" wire:click="addCart">Add</button>
            </div>
        <p class="text-xs text-gray-600 "><span class="font-medium">Availability: {{ $track->capacity }}</p>
    </div>
</div>