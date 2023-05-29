@extends('customer.partials.layout')

@section('main')
    <div class="px-4">
        <p class="text-2xl font-bold mb-6 border-b-2 border-gray-200">Deposite Transaction</p>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Debit
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Credit
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $history->created_at }}
                        </th>
                        <td class="px-6 py-4">
                            {{ number_format($history->debit, '0', ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($history->credit, '0', ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $history->description }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-1">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
@endsection