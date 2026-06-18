@extends('layouts.app')

@section('title','Listado de Pagos')

@section('content')

<div class="content-wrapper">
    <section class="content-header" style="text-align: right;">
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
                            
                            <a href="{{ route('pagos.create') }}" class="btn btn-primary float-right" title="Nuevo"><i class="fas fa-plus"></i></a>
    
                            <a href="{{ route('pagos.papelera') }}" class="btn btn-warning float-right mr-2" title="Papelera">
                                <i class="fas fa-trash"></i> Papelera
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <th width="10px">#</th> <th>Cliente</th> <th>Factura N°</th> 
                                    <th>Método de Pago</th>
                                    <th>Monto</th>
                                    <th>Fecha de Pago</th>
                                    <th width="90px">Acción</th>
                                </thead>
                                <tbody>
                                    @foreach($pagos as $pago)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $pago->factura && $pago->factura->cliente ? $pago->factura->cliente->nombre : 'Cliente no disponible' }}</td>
                                        
                                        <td>{{ $pago->factura_id }}</td>

                                        <td>{{ $pago->metodoPago ? $pago->metodoPago->tipo : 'N/A' }}</td>
                                        
                                        <td>${{ number_format($pago->monto, 2) }}</td>
                                        <td>{{ $pago->fecha_pago }}</td>
                                        
                                        <td>
                                            <a href="{{ route('pagos.edit', $pago->id) }}" class="btn btn-info btn-sm" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form class="d-inline delete-form" action="{{ route('pagos.destroy', $pago) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" 
                                                    onclick="return confirm('¿Está seguro de que desea eliminar este pago y moverlo a la papelera?')">
                                                    <i class="fas fa-trash-alt"></i>
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
            </div>
        </div>
    </section>
 </div>
@endsection