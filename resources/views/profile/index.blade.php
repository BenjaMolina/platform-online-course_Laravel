@extends('layouts.app')


@section('jumbotron')
    @include('partials.jumbotron',[
        'title' => "Configurar tu perfil",
        'icon' => "user-circle"
    ])
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endpush

@section('content')
    
@endsection