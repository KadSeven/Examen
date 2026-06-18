@extends('layouts.app')

@section('title','Papelera de Pagos')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">@yield('title')</h3>
                    <a href="{{ route('pagos.index') }}" class="btn btn-secondary float-right">Volver</a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Factura/Cliente</th>
                                <th>Monto</th>
                                <th>Fecha Pago</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagos as $pago)
                            <tr>
                                <td>{{ $pago->id }}</td>
                                <td>
                                    {{ $pago->factura->cliente->nombre ?? 'Sin Cliente' }} 
                                    (Fac. #{{ $pago->factura_id }})
                                </td>
                                <td>{{ $pago->monto }}</td>
                                <td>{{ $pago->fecha_pago }}</td>
                                <td>
                                    <form action="{{ route('pagos.restaurar', $pago->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-undo"></i> Restaurar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection