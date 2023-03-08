@if($trackDepartures != null)
<div class="w-full max-w-5xl mx-auto pt-3 md:pt-12 px-2">
    @if($from != '' && $to != '')
        <div class="pb-2 text-xl font-bold flex flex-row gap-2"> 
            <div>{{ $from }}</div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
            <div> {{ $to }} </div>
        </div>
    @endif
        <div class="flex flex-col">
        @foreach($trackDepartures as $track)
            <livewire:fastboat-item :track="$track" :date="$date" ordered="0"/>
        @endforeach
        </div>
</div>
<div class=" max-w-5xl mx-auto px-1 {{ $trackDepartures == null ? 'pb-10' : '' }}">
    
</div>
@endif

@if($trackReturns != null)
<div class="w-full max-w-5xl mx-auto pt-3 md:pt-10 px-2">
    @if($from != '' && $to != '')
        <div class="pb-2 text-xl font-bold flex flex-row gap-2"> 
            <div> {{ $to }} </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
            <div>{{ $from }}</div>
        </div>
    @endif
    <div class="flex flex-col">
    @foreach($trackReturns as $track)
        <livewire:fastboat-item :track="$track" :date="$rdate" ordered="0"/>
    @endforeach
    </div>
</div>
<div class=" max-w-5xl mx-auto px-1 {{ $trackReturns == null ? 'pb-10' : '' }}">
    {{$trackReturns->withQueryString()->links()}}
</div>
@endif