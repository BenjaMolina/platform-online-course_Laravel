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
    <div class="pl5 pr5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __("Actualiza tus datos") }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="post" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">
                                    {{ __("Correo electronico") }}
                                </label>
                                <div class="col-md-6">
                                    <input 
                                        id="email"
                                        type="email"
                                        name="email"
                                        readonly 
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : ''}}"
                                        value="{{ old('email') ?: $user->email }}"
                                        required
                                        autofocus
                                    >
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">
                                    {{ __("Contraseña") }}
                                </label>
                                <div class="col-md-6">
                                    <input 
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : ''}}"      
                                        required                                        
                                    >
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">
                                    {{ __("Confirmar constraseña") }}
                                </label>
                                <div class="col-md-6">
                                    <input 
                                        id="password-confirm"
                                        name="password-confirmation"
                                        type="password"
                                        class="form-control"      
                                        required                                        
                                    >
                                </div>
                            </div>

                            <div class="form-group mb-0 row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __("Actualizar datos") }}
                                    </button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection