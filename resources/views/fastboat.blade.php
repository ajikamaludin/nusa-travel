@extends('layouts.home')

@section('content')
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset('images/2.jpg')}}" class="w-full brightness-75 h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="block z-40 mt-20 w-full lg:w-2/3 mx-auto max-w-5xl h-60"> 
            <div class="bg-white rounded-lg border-gray-200 shadow-lg px-8 py-6">
                <x-fastboat-schedule :ways="$ways" :from="$from" :to="$to" :date="$date" :rdate="$rdate" :passengers="$no_passengers"/>
            </div>
        </div>
    </section>
    <div class="w-full max-w-5xl mx-auto pt-80 mt-10 md:mt-0 md:pt-20">
        <!-- removed cart order -->
    </div>
    <livewire:fastboat-track-available :ways="$ways" :from="$from" :to="$to" :date="$date" :rdate="$rdate" :passengers="$no_passengers"/>
    <div class="py-10"></div>
@endsection