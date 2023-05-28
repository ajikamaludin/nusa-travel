@extends('layouts.home')

@section('content')
    <div class="w-full mx-auto max-w-7xl px-2 py-5">
        <div class="mx-auto p-6 flex flex-col">
            <div class="text-2xl font-bold">Credit/Debit Card Payment</div>
            <iframe src="{{ $payment_url }}" class="w-full h-screen"></iframe>
        </div>
    </div>
@endsection
