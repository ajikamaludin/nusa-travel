<form method="GET" action="{{ route('fastboat') }}">
    <!-- @csrf -->
    <div class="flex flex-row w-full">
        <ul class="items-center w-full md:w-1/2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                <div class="flex items-center pl-3">
                    <input id="one-way" type="radio" {{ $ways == 1 ? 'checked' : '' }} value="1" name="ways" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"/>
                    <label for="one-way" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('website.One way')}}</label>
                </div>
            </li>
            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                <div class="flex items-center pl-3">
                    <input id="round-trip" type="radio" {{ $ways == 2 ? 'checked' : '' }} value="2" name="ways" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                    <label for="round-trip" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('website.Round Trip')}}</label>
                </div>
            </li>

        </ul>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 pt-4 gap-2" id="form-wrapper">
        <div class="md:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <livewire:select-origin :origin="$to" :dest="$from"/>
                <livewire:select-destination :dest="$from" :origin="$to"/>
                <livewire:select-date :date="$date" />
                <div class="{{ $ways == 1 ? 'hidden' : ''}}" id="rdate">
                    <livewire:select-return-date :rdate="$rdate" :date="$date"/>
                </div>
            </div>
        </div>
        <livewire:select-passenger :passengers="1" :infants="0"/>
    </div>
    <div class="w-full flex flex-row justify-end pt-2">
        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="submit">
            {{ __('website.Search') }}
        </button>
    </div>
</form>

@push('script')
<script>
    if (document.querySelector('input[name="ways"]')) {
        document.querySelectorAll('input[name="ways"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
            var item = event.target.value;
                wrap = document.getElementById('form-wrapper')
                rdate = document.getElementById('rdate')
                if(+item == 2) {
                    rdate.classList.remove('hidden')
                } else {
                    rdate.classList.add('hidden')
                }
            });
        });
    }
</script>
@endpush