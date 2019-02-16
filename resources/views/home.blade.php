@extends('layouts.app')

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            @forelse ($cursos as $curso)
                <div class="col-md-3">
                    {{ $curso->name }}
                </div>
            @empty
                <div class="alert alert-dark">
                    {{ __('No hay ningun curso disponible') }}
                </div>
            @endforelse
        </div>

        <div class="row justify-content-center">
            {{ $cursos->links() }}
        </div>
    </div>
@endsection
