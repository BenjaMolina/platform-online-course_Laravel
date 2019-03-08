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
                                        name="password_confirmation"
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


                @if (! $user->teacher)
                    <div class="card">
                        <div class="card-header">
                            {{ __("Convertirme en profesor de la plataforma") }}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('solicitude.teacher') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-block">
                                    <i class="fa fa-graduation-cap"></i>{{ __("Solicitar") }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            {{ __("Administrar los cursos que imparto") }}
                        </div>
                        <div class="card-body">
                            <a href="{{ route('teacher.courses') }}" class="btn btn-secondary btn-block">
                                <i class="fa fa-leanpub"></i> {{__("Administrar ahora")}}
                            </a>
                        </div>
                    </div>

                   <div class="card">
                       <div class="card-header">
                           {{ __("Mis estudiantes") }}
                       </div>
                       <div class="card-body">
                        <table 
                            class="table table-striped table-bordered nowrap"
                            cellspacing="0"
                            id="students-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ __("ID") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Email") }}</th>
                                    <th>{{ __("Cursos") }}</th>
                                    <th>{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                        </table>
                       </div>
                   </div>
                @endif
            </div>
        </div>
    </div>
    @include('partials.modal')
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        let dt,
            modal = $("#appModal");

        $(document).ready(function(){
            //Configuracion de la tabla DattaTable
            dt = $("#students-table").DataTable({
                pageLength: 5,
                lengthMenu: [5,10,25,75,100],
                processing: true,
                serverSide: true,
                ajax:'{{ route('teacher.students') }}',
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                columns:[
                    {data: 'user.id'},
                    {data: 'user.name'},
                    {data: 'user.email'},
                    {data: 'courses_formatted'},
                    {data: 'actions'},
                ],
            });

            //Hacemos referencia al boton de accion del DataTable, para mostrar el modal
            $(document).on('click', '.btnEmail', function(e){   
                e.preventDefault();
                const id = $(this).data('id');
                
                modal.find('.modal-title').text('{{ __("Enviar mensaje") }}');
                modal.find('#modalAction').text('{{ __("Enviar mensaje") }}').show();

                let $form = $("<form id='studentMessage'></form>");
                $form.append(`<input type"hidden" name="user_id" vale=${id}`);
                $form.append(`<textarea class="form-control" name="message"></textarea>`);

                modal.find('.modal-body').html($form);

                modal.modal();

            });

            $(document).on('click', '#modalAction', function(e){
                $.ajax({
                    url: "{{ route('teacher.send_message_to_student') }}",
                    type:'POST',
                    headers: {
                        'x-csrf-token': $("meta[name=csrf-token]").attr('content')
                    },
                    data: {
                        info: $("#studentMessage").serialize()
                    },
                    success:(res) => {
                        if(res.res){
                            modal.find('#modalAction').hide();
                            modal.find('.modal-body').html('<div class="alert alert-success">{{ __("Mensaje enviado correctamente") }}</div>')
                        }
                        else{
                            modal.find('.modal-body').html('<div class="alert alert-danger">{{ __("Ha ocurrido un error mensaje enviado el correo") }}</div>')
                        }
                    },
                })
            })
        });
    </script>
@endpush