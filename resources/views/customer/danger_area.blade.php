@extends('customer.partials.layout')

@section('main')
    <div class="px-4">
        <p class="text-2xl font-bold mb-6 border-b-2 border-gray-200">Danger Area</p>
        <div class="flex flex-row">
            <div class="w-full">
                @if (session()->has('message'))
                    <x-alert type="{{ session()->get('message.type') }}" message="{{ session()->get('message.message') }}" />
                @endif
                @error('deleted_reason')
                    <x-alert type="error" message="{{ $message }}" />
                @enderror
                <button 
                    onclick="iwantdelete()"
                    id="iwantdelete"
                        class="text-white mt-4 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">I want delete my account</button>
                <form method="POST" action="{{ route('customer.delete') }}" style="display: none" id="form">
                    @csrf
                    <textarea class="w-full block p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 " name="deleted_reason" placeholder="reason to delete action" rows="8"></textarea>
                    
                    <button type="submit"
                    onclick="return confirm('Are you sure?')"
                        class="text-white mt-4 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    const iwantdelete = () => {
        const confirmed = confirm('Are you sure?')
        if (confirmed === true) {
            document.getElementById('iwantdelete').classList.add('hidden')
            document.getElementById('form').style.display = 'block'
            return;
        }
    }
</script>
@endpush