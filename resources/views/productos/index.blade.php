@extends('layouts.app')

@section('title','Listado de Productos')

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
                            
                            <a href="{{ route('productos.create') }}" class="btn btn-primary float-right ml-2" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
                            
                            <a href="{{ route('productos.papelera') }}" class="btn btn-warning float-right" title="Ver Borrados">
                                <i class="fas fa-trash nav-icon"></i> Papelera
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <th width="10px">ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio de venta</th>
                                    <th>Stock</th>
                                    <th>Stock Mínimo</th>
                                    <th style="width: 110px; text-align: center;">Imagen</th>
                                    <th width="60px">Estado</th>
                                    <th width="90px">Acción</th>
                                </thead>
                                <tbody>
                                    @foreach($productos as $producto)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $producto->id }}</td>
                                        <td style="vertical-align: middle;">{{ $producto->nombre }}</td>
                                        <td style="vertical-align: middle;">{{ $producto->descripcion }}</td>
                                        <td style="vertical-align: middle;">{{ number_format($producto->precio_venta, 2) }}</td>
                                        <td style="vertical-align: middle;">{{ $producto->stock }}</td>
                                        <td style="vertical-align: middle;">{{ $producto->stock_minimo }}</td>
                                        
                                        {{-- SECCIÓN CORREGIDA DE LA IMAGEN --}}
                                        <td style="text-align: center; vertical-align: middle;">
                                            @if(!empty($producto->imagen) && file_exists(public_path('images/productos/' . $producto->imagen)))
                                                <img src="{{ asset('images/productos/' . $producto->imagen) }}" 
                                                     alt="{{ $producto->nombre }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                                            @else
                                                <span class="badge bg-light text-secondary border p-2" style="font-weight: 500; font-size: 11px;">
                                                    <i class="far fa-image me-1"></i> Sin foto
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td style="vertical-align: middle;">
                                            <input data-type="producto" data-id="{{$producto->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
                                                data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $producto->estado ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-info btn-sm" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form class="d-inline delete-form" action="{{ route('productos.destroy', $producto) }}"  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este producto?')">
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