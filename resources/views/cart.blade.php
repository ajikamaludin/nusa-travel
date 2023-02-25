@extends('layouts.home')

@section('content')
    <livewire:cart :carts="$carts"/>
@endsection