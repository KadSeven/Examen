@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-3" style="border-top: 3px solid #6c757d;">
                <div class="card-header" style="background-color: #6c757d; color: white;">
                    <h3 class="card-title" style="font-size: 1.25rem; font-weight: 500;">
                        Editar Producto: {{ $producto->nombre }}
                    </h3>
                </div>
                
                @include('layouts.partial.msg')

                <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" style="font-weight: 600; color: #333;">
                                        Nombre del Producto <span style="color: red;"></span>
                                    </label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio_venta" style="font-weight: 600; color: #333;">
                                        Precio de Venta ($) <span style="color: red;"></span>
                                    </label>
                                    <input type="number" step="0.01" name="precio_venta" class="form-control" value="{{ old('precio_venta', $producto->precio_venta) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion" style="font-weight: 600; color: #333;">Descripción</label>
                                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock" style="font-weight: 600; color: #333;">
                                        Stock Actual <span style="color: red;"></span>
                                    </label>
                                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $producto->stock) }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_minimo" style="font-weight: 600; color: #333;">
                                        Stock Mínimo <span style="color: red;"></span>
                                    </label>
                                    <input type="number" name="stock_minimo" class="form-control" value="{{ old('stock_minimo', $producto->stock_minimo) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" style="background-color: rgba(0,0,0,.03);">
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white; padding: .375rem .75rem;">
                            Actualizar Producto
                        </button>
                        <a href="{{ route('productos.index') }}" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545; color: white; margin-left: 5px; padding: .375rem .75rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection