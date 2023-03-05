@extends('layouts.home')

@section('content')
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset('images/2.jpg')}}" class="w-full brightness-75 h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="md:block absolute z-40 -bottom-10 left-1/2 -translate-x-1/2 w-full lg:w-2/3 mx-auto max-w-5xl h-60"> 
            <div class="bg-white rounded-lg border-gray-200 shadow-lg px-8 py-6">
                <x-fastboat-schedule :ways="$ways" :from="$from" :to="$to" :date="$date" :rdate="$rdate"/>
            </div>
        </div>
    </section>
    <div class="w-full max-w-5xl mx-auto pt-72 md:pt-20">
        <livewire:order-cart/>
    </div>
    @if($tracks_one != null)
    <div class="w-full max-w-5xl mx-auto pt-3 md:pt-12 px-2">
        @if($from != '' && $to != '')
            <div class="pb-2 text-xl font-bold"> Trip from {{ $from }} to {{ $to }} </div>
        @endif
            <div class="flex flex-col">
            @foreach($tracks_one as $track)
                <livewire:fastboat-item :track="$track" :date="$date" :ordered="$track->item_ordered_count"/>
            @endforeach
            </div>
    </div>
    <div class=" max-w-5xl mx-auto px-1 {{ $tracks_two == null ? 'pb-10' : '' }}">
        {{$tracks_one->withQueryString()->links()}}
    </div>
    @endif

    @if($tracks_two != null)
    <div class="w-full max-w-5xl mx-auto pt-3 md:pt-10 px-2">
        @if($from != '' && $to != '')
        <div class="flex flex-row justify-between mb-1">
            <div class="pb-2 text-xl font-bold"> Trip from {{ $to }} to {{ $from }} </div>
        </div>
        @endif
        <div class="flex flex-col">
        @foreach($tracks_two as $track)
            <livewire:fastboat-item :track="$track" :date="$rdate" :ordered="$track->item_ordered_count"/>
        @endforeach
        </div>
    </div>
    <div class=" max-w-5xl mx-auto px-1 {{ $tracks_two == null ? 'pb-10' : '' }}">
        {{$tracks_two->withQueryString()->links()}}
    </div>
    @endif
    <div class="py-10"></div>
@endsection