@extends('layouts.app')

@section('title','Listado de Facturas')

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
                            
                            <a href="{{ route('facturas.create') }}" class="btn btn-primary float-right" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
                            
                            <a href="{{ route('facturas.papelera') }}" class="btn btn-warning float-right mr-2" title="Ver Borrados">
                                <i class="fas fa-trash nav-icon"></i> Papelera
                            </a>

                            {{-- BOTÓN PRINCIPAL SUPERIOR: Exportar el Excel General de todas las facturas --}}
                            {{-- BOTÓN EXCEL GENERAL ESTILIZADO --}}
                            <a href="{{ route('facturas.excelgeneral') }}" class="btn btn-success text-white px-3" style="height: 38px; display: inline-flex; align-items: center; gap: 5px;" title="Exportar todas las facturas a Excel">
                                <i class="fas fa-file-excel"></i> Exportar Excel General
                            </a>
                            
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <th width="10px">ID</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Cliente</th>
                                    <th>Tipo de pago</th>
                                    <th>Saldo pendiente</th>
                                    <th width="60px">Estado</th>
                                    <th width="120px">Acción</th> {{-- Aumenté un poco el ancho para que quepan los 3 botones --}}
                                </thead>
                                <tbody>
                                    @foreach($facturas as $factura)
                                    <tr>
                                        <td>{{ $factura->id }}</td>
                                        <td>{{ $factura->fecha }}</td>
                                        <td>{{ $factura->total }}</td>
                                        
                                        <td>{{ $factura->cliente->nombre ?? 'Cliente en Papelera' }}</td>
                                        
                                        <td>{{ $factura->metodo_pago->tipo ?? 'Sin método' }}</td>
                                        <td>{{ $factura->saldopendiente }}</td>
                                        <td class="text-center">
                                            @if($factura->estado == '1' || $factura->estado == 'Activo')
                                                <span class="badge badge-success" style="font-size: 1rem; padding: 0.5rem 1rem;">Activo</span>
                                            @else
                                                <span class="badge badge-danger" style="font-size: 1rem; padding: 0.5rem 1rem;">Inactivo</span>
                                            @endif
                                        </td>
                                        <td nowrap>
                                            <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                            
                                            {{-- NUEVO BOTÓN: Imprimir PDF Corregido --}}
                                            <a href="{{ route('facturas.imprimirfactura', $factura->id) }}" class="btn btn-danger btn-sm text-white" title="Imprimir PDF" target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            
                                            <form class="d-inline delete-form" action="{{ route('facturas.destroy', $factura) }}"  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Seguro que desea mover esta factura a la papelera?')">
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