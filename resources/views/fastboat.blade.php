@extends('layouts.home')

@section('css')
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.8.6/dist/css/autocomplete.min.css"/>
    <!-- js -->
    <script src="https://cdn.jsdelivr.net/gh/tomik23/autocomplete@1.8.6/dist/js/autocomplete.min.js"></script>
@endsection

@section('content')
    <!-- Hero Blog -->
    <section class="w-full min-h-[250px] relative flex flex-col items-center justify-center">
        <img src="{{asset('images/2.jpg')}}" class="w-full brightness-75 h-full rounded object-cover blur-[1px] absolute top-0" alt="...">
        <div class="md:block absolute z-40 -bottom-10 left-1/2 -translate-x-1/2 w-full lg:w-2/3 mx-auto h-60"> 
            <div class="bg-white rounded-lg border-gray-200 shadow-lg px-8 py-6">
                <form method="GET" action="{{ route('fastboat.index') }}">
                <!-- @csrf -->
                <div class="flex flex-row w-full ">
                    <ul class="items-center w-1/2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="horizontal-list-radio-license" type="radio" {{ $ways == 1 ? 'checked' : '' }} value="1" name="ways" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="horizontal-list-radio-license" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">One way </label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center pl-3">
                                <input id="horizontal-list-radio-id" type="radio" {{ $ways == 2 ? 'checked' : '' }} value="2" name="ways" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="horizontal-list-radio-id" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Round Trip</label>
                            </div>
                        </li>

                    </ul>
                </div>
                <div class="grid grid-cols-3 pt-4 gap-2">
                    <div class="auto-search-wrapper">
                        <input type="text" id="from" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full" placeholder="From" name="from" autocomplete="off" value="{{ $from }}">
                    </div>
                    <div class="auto-search-wrapper">
                        <input type="text" id="to" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full" placeholder="To" name="to" autocomplete="off" value="{{ $to }}">
                    </div>
                    <div>
                        <input type="date" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Date" required autocomplete="off" name="date" value="{{ $date }}" min="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="w-full flex flex-row justify-end pt-2">
                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">{{ __('website.Search') }}</button>
                </div>
                </form>
            </div>
        </div>
    </section>
    @if($tracks_one != null)
    <div class="w-full max-w-5xl mx-auto pt-3 md:pt-20 px-2 {{ $tracks_two == null ? 'pb-10' : '' }}">
        <div class="pb-2 text-xl font-bold"> Trip from {{ $from }} to {{ $to }} </div>
        <div class="flex flex-col">
        @foreach($tracks_one as $track)
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
                    <form method="POST" action="{{ route('fastboat.order', $track) }}">
                        <div class="flex flex-row gap-2 justify-end">
                            @csrf
                            <input type="number" value="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 w-1/3" name="qty"/>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Order</button>
                        </div>
                    </form>
                    <p class="text-xs text-gray-600 "><span class="font-medium">Availability: {{ $track->capacity }}</p>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    @endif

    @if($tracks_two != null)
    <div class="w-full max-w-5xl mx-auto pt-3 md:pt-10 px-2 b-10 pb-5">
        <div class="pb-2 text-xl font-bold"> Trip from {{ $to }} to {{ $from }} </div>
        <div class="flex flex-col">
        @foreach($tracks_two as $track)
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
                        <input type="number" value="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 w-1/3"/>
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 ">Order</button>
                    </div>
                    <p class="text-xs text-gray-600 "><span class="font-medium">Availability: {{ $track->capacity }}</p>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    @endif
    <div class="py-10"></div>
@endsection

@section('js')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const options = {
                showAllValues: true,
                onSearch: ({ currentValue }) => {
                    const api = `{{ route('api.fastboat.place.index') }}?q=${encodeURI(
                        currentValue
                    )}`;
                    return new Promise((resolve) => {
                    fetch(api)
                        .then((response) => response.json())
                        .then((data) => {
                            resolve(data);
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                    });
                },

                onResults: ({ matches }) => {
                    return matches
                        .map((el) => {
                        return `
                            <li>${el.name}</li>`;
                        })
                        .join('');
                    },
            }

            // 'local' is the 'id' of input element
            new Autocomplete('from', options);
            new Autocomplete('to', options);
        });
    </script>
@endsection