@extends('layouts.app')


@section('jumbotron')
    @include('partials.jumbotron',[
        'title'=> __("Manejar mis subscripciones"),
        'icon' => 'list-ol'
    ])
@endsection

@section('content')
    <div class="pl-5 pr5">
        <div class="row justify-content-around">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Plan</th>
                        <th scope="col">ID Suscripcion</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Alta</th>
                        <th scope="col">Finaliza en</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subscriptions as $subscription)
                        <td>{{ $subscription->id }}</td>
                        <td>{{ $subscription->name }}</td>
                        <td>{{ $subscription->stripe_plan }}</td>
                        <td>{{ $subscription->stripe_id }}</td>
                        <td>{{ $subscription->quantity }}</td>
                        <td>{{ $subscription->created_at->format('d/m/y') }}</td>
                        <td>{{ $subscription->ends_at ? $subscription->ends_at->format('d/m/y') : __("Suscripcion activa") }}</td>
                        <td>
                            @if ($subscription->ends_at)
                                <form action="{{ route('subscriptions.resume') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="plan" value="{{ $subscription->name }}">
                                    <button class="btn btn-success">
                                        {{ __("Reanudar") }}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('subscriptions.cancel') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="plan" value="{{ $subscription->name }}">
                                    <button class="btn btn-success">
                                        {{ __("Cancelar") }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    @empty
                        <tr>
                            <td colspan="8">{{__("No hay ninguna suscripcion disponible")  }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection