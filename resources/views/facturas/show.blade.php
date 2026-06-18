@extends('layouts.app')

@section('title','Ver Datos De La Factura')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>
    @include('layouts.partial.msg')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                        </div>
                        <div class="card-body">
                            <div class="panel panel-primary">
                                <div class="panel-body">

                                    {{-- FILA 1: Cliente y Fecha --}}
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Cliente</label>
                                                <p>{{ $factura->cliente->nombre ?? 'Sin cliente' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Fecha</label>
                                                {{-- Formato amigable para el usuario --}}
                                                <p>{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y g:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FILA 2: Total, Saldo Pendiente, Estado --}}
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Total</label>
                                                <p>$ {{ number_format($factura->total, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Saldo Pendiente</label>
                                                <p>$ {{ number_format($factura->saldopendiente ?? 0, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Estado</label>
                                                <p>
                                                    <span class="badge {{ $factura->estado ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $factura->estado ? 'Activo' : 'Inactivo' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FILA 3: Tipo Pago y Registrado Por --}}
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Tipo de Pago</label>
                                                <p>{{ $factura->metodo_pago->tipo ?? 'Sin método' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Registrado Por</label>
                                                <p>{{ $factura->registrado_por ?? 'No especificado' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FILA 4: Detalle de Productos --}}
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label" style="font-weight: bold;">Detalle de Productos</label>
                                                <table class="table table-bordered table-striped">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Producto</th>
                                                            <th>Cantidad</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($factura->detallefacturas as $detalle)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $detalle->producto->nombre ?? 'Sin producto' }}</td>
                                                            <td>{{ $detalle->cantidad }}</td>
                                                            <td>$ {{ number_format($detalle->subtotal, 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="3" class="text-right">Total:</th>
                                                            <th>$ {{ number_format($factura->total, 2) }}</th>
                                                        </tr>
                                                    </footer>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('facturas.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection