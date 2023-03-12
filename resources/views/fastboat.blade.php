@extends('layouts.home')

@section('content')
    <x-dialog z-index="z-50" blur="md" align="center" />
    <livewire:fastboat :ways="$ways" :from="$from" :to="$to" :date="$date" :rdate="$rdate" :passengers="$no_passengers"/>
    <div class="my-96 md:my-20"></div>
@endsection