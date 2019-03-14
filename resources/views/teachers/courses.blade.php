@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',[
        'title' => 'Cursos que imparto',
        'icon' => 'building'
    ])
@endsection

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            @forelse ($courses as $course)
                <div class="col-md-8 offset-2 listing-block">
                    <div class="media" style="height: 200px;">
                        <img 
                            style="height:200px; width:300px"
                            src="{{ $course->pathAttachment() }}"
                            alt="{{ $course->name }}">
                        <div class="media-body pl-3" style="height:200px">
                            <div class="price">
                                <small class="badge-danger text-white text-center">
                                    {{ $course->category->name }}
                                </small>
                                <small>{{ __("Curso") }}: {{ $course->name }}</small>
                                <small>{{ __("Estudiantes") }}: {{ $course->students_count }}</small>
                            </div>
                            <div class="stats">
                                {{ $course->created_at->format('d/m/y') }}
                                @include('partials.courses.rating', [
                                    'rating' => $course->custom_rating
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-dark">
                    {{ __("No tienes ningun curso todavia") }}
                    <a href="{{ route("courses.create") }}" class="btn btn-course btn-block">
                        {{ __("Crear mi primer curso!") }}
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection