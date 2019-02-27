@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pricing.css') }}">
@endpush


@section('jumbotron')
    @include('partials.jumbotron',[
        'title'=> __("Subscribete ahora a uno de nuestros planes"),
        'icon' => 'globe'
    ])
@endsection

@section('content')
    
@endsection