<form method="GET" action="{{ route('car.index') }}">
    <!-- @csrf -->
    <div class="text-2xl font-bold">
        Car rentals
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 pt-4 gap-2" id="form-wrapper">
        <div>
            <input type="number" id="person" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Persons" name="person" autocomplete="off" value="{{ $person }}">
        </div>
        <div class="w-full">
            <input type="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Date" required autocomplete="off" name="date" value="{{ $date }}" min="{{ now()->format('Y-m-d') }}">
        </div>
    </div>
    <div class="w-full flex flex-row justify-end pt-2">
        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">{{ __('website.Search') }}</button>
    </div>
</form>