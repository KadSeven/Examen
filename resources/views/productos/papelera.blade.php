@extends('layouts.app')

@section('title','Papelera de Productos')

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
                        <div class="card-header bg-dark" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary float-right" title="Volver al listado">
                                <i class="fas fa-arrow-left nav-icon"></i> Volver
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <th width="10px">ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th width="90px">Acción</th>
                                </thead>
                                <tbody>
                                    @foreach($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->id }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->precio_venta }}</td>
                                        <td>{{ $producto->stock }}</td>
                                        <td>
                                            <form action="{{ route('productos.restaurar', $producto->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Restaurar"
                                                    onclick="return confirm('¿Desea restaurar este producto?')">
                                                    <i class="fas fa-undo-alt"></i> Restaurar
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