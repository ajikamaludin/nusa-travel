@extends('layouts.home')

@section('css')
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.8.6/dist/css/autocomplete.min.css"/>
    <!-- js -->
    <script src="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.8.6/dist/js/autocomplete.min.js"></script>
@endsection

@section('content')
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset('images/2.jpg')}}" class="w-full brightness-75 h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="md:block absolute z-40 -bottom-10 left-1/2 -translate-x-1/2 w-full lg:w-2/3 mx-auto max-w-5xl h-60"> 
            <div class="bg-white rounded-lg border-gray-200 shadow-lg px-8 py-6">
                <x-car-rental :date="$date" :person="$person"/>
            </div>
        </div>
    </section>
    @if($cars != null)
    <div class="w-full max-w-5xl mx-auto pt-3 mt-10 px-2">
            <div class="flex flex-col">
            @foreach($cars as $car)
                <livewire:car-item :car="$car" :date="$date"/>
            @endforeach
            </div>
    </div>
    <div class=" max-w-5xl mx-auto px-1">
        {{$cars->withQueryString()->links()}}
    </div>
    @endif

    <div class="py-10"></div>
@endsection