@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron',[
        'title' => 'Manejar mis facturas',
        'icon' => 'archive',
    ])
@endsection

@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th>{{ __('Fecha de la suscripcion') }}</th>
                        <th>{{ __('Coste de la suscripcion') }}</th>
                        <th>{{ __('Cupon') }}</th>
                        <th>{{ __('Descargar facturas') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->date()->format('d/m/Y') }}</td>
                            <td>{{ $invoice->total() }}</td>
                            @if ($invoice->hasDiscount())
                                <td>
                                    {{ __('Cupon') }} : ({{ $invoice->coupon() }} / {{ $invoice->discount() }})
                                </td>
                            @else
                                <td>{{ __("No se ha utilizado ningun cupon") }}</td>
                            @endif
                            <td>
                                <a href="{{ route('invoices.download',$invoice->id) }}" class="btn btn-course">{{ __("Descargar") }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr colspan="4">{{ __("No hay ninguna factura disponible") }}</tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection