<x-modal 
    blur 
    wire:model.lazy="show"
    spacing="p-0"
    align="center"
>
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow items-center h-full md:h-auto">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <div class="flex flex-col">
                    <div wire:loading.delay.long>
                        <h3 class="text-xl font-semibold text-gray-900">loading...</h3>
                    </div>
                    <!-- header tracks from -> to -->
                    <h3 class="text-xl font-semibold text-gray-900 flex flex-row items-center gap-2" wire:loading.remove>
                    @if($trackDepartureChoosed == null)
                        <div>{{ $from }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                        <div> {{ $to }} </div>
                    @else 
                        <div>{{ $to }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                        <div> {{ $from }} </div>
                    @endif 
                    </h3>
                    <div class="flex flex-row gap-2" wire:loading.remove>
                        <p>{{ Carbon::parse($trackDepartureChoosed != null ? $rdate : $date)->format('d M Y') }}</p>
                        <div>|</div>
                        <p>{{ $passengers + $infants }} {{ __('website.passengers')}}</p>
                    </div>
                </div>
                <button type="button" wire:click="toggle" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg wire:loading.remove aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only"> _ </span>
                </button>
            </div>

            <!-- choosed departure if 2 ways -->
            @if($trackDepartureChoosed != null)
            <div class="w-full max-w-5xl mx-auto px-4 py-2 border-b-2">
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-col">
                        <p class="font-bold">{{ __('website.Departure Fastboat')}}</p>
                        <div class="flex flex-row gap-2 text-sm">
                            <p>{{$trackDepartureChoosed->group->fastboat->name}} </p>
                            <p>|</p>
                            <p>Rp {{ number_format($trackDepartureChoosed->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="text-blue-600" wire:click="changeDepartureFastboat">
                        {{ __('website.Change')}}
                    </div>
                </div>
            </div>
            @endif

            <!-- no choosed departure -->
            @if($trackDepartureChoosed == null)
            <div class="w-full text-center max-w-5xl text-sm font-light mx-auto px-4 py-2 border-b-2">
                <p>{{ __('website.Choose departure fastboat')}}</p>
            </div>
            @endif

            <!-- tracks  -->
            @if($trackDepartures != null)
                @if($trackDepartureChoosed == null)
                <div class="w-full max-w-5xl mx-auto p-2">
                    <div class="flex flex-col" wire:loading.remove>
                    @foreach($trackDepartures as $track)
                        <livewire:fastboat-item :track="$track" :date="$date" :quantity="$passengers" :type='1' :wire:key="$track->id.$date"/>
                    @endforeach
                    </div>
                </div>
                <div class=" max-w-5xl mx-auto px-2 {{ $trackDepartures == null ? 'pb-10' : '' }}">
                    {{$trackDepartures->withQueryString()->links()}}
                </div>
                @endif

                <!-- route return -->
                @if($trackReturns != null && $trackDepartureChoosed != null)
                    <div class="w-full max-w-5xl mx-auto p-2">
                        <div class="flex flex-col" wire:loading.remove>
                        @foreach($trackReturns as $track)
                            <livewire:fastboat-item :track="$track" :date="$rdate" :quantity="$passengers" :type='2' :wire:key="$track->id"/>
                        @endforeach
                        </div>
                    </div>
                    <div class=" max-w-5xl mx-auto px-1 {{ $trackReturns == null ? 'pb-10' : '' }}">
                        {{$trackReturns->withQueryString()->links()}}
                    </div>
                    @if($trackReturns?->count() <= 0)
                        <p class="w-full text-center py-20">{{ __('website.no fastboat schedule found')}}</p>
                    @endif
                @endif
            @endif

            <!-- no route found -->
            @if($trackDepartures?->count() <= 0)
                <p class="w-full text-center py-20">{{ __('website.no fastboat schedule found')}}</p>
            @endif
        </div>
    </div>
</x-modal>
