<div class="px-6 py-4 mb-1 shadow flex flex-col gap-2 border-2 border-gray-200 rounded">
    <div class="flex flex-row justify-between">
        <div class="text-base">
            <p>
                {{ $track->group->fastboat->name }}
            </p>
            {{-- <p class="text-xs text-gray-400">{{ $track->group->fastboat->number }}</p> --}}
            <p class="text-xs text-gray-400">
                @if($track->data_source != null)
                    By Ekajaya, 
                @endif
                {{ __('website.seats')}}: {{ $track->group->fastboat->capacity }}
            </p>
            
        </div>
        <div class="text-base text-right">
            <span class="font-bold flex-none"> Rp {{ number_format($track->validated_price, 0, ',' , '.') }}</span><span class="text-xs">/pax</span>
            <p class="text-xs text-gray-400">{{ __('website.availability')}}: {{ $avalaible }}</p>
        </div>
    </div>
    <div class="flex flex-row justify-between text-center items-center font-bold gap-1">
        <div class="flex flex-row gap-4 text-center items-center">
            <div>
                <p>{{ $track->arrival_time }}</p>
                <p>{{ $track->source->name }}</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </div>
            <div>
                <p>{{ $track->departure_time }}</p>
                <p>{{ $track->destination->name }}</p>
            </div>
        </div>
        @if($avalaible >= $quantity)
            <button 
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                wire:click="addCart({{ $type }})"
                wire:loading.remove
            >
                {{ __('website.Choose')}}
            </button>
        @else
        <div class="md:p-4 my-4 text-sm text-red-800 rounded-lg md:bg-red-50" role="alert">
            @if($avalaible > 0)
                <span class="font-medium">{{ __('website.Oops, not enough seats')}}</span> 
            @else
                <span class="font-medium">{{ __('website.Sold out')}}</span> 
            @endif
        </div>
        @endif
        <div wire:loading.delay.long>
            loading...
        </div>
    </div>
</div>