@extends('layouts.app')

@section('title','Crear Producto')

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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                        </div>
                        <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Nombre <strong style="color:red;"></strong></label>
                                            <input type="text" class="form-control" name="nombre" placeholder="Nombre del producto" value="{{ old('nombre') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Precio de Venta <strong style="color:red;"></strong></label>
                                            <input type="number" step="0.01" class="form-control" name="precio_venta" placeholder="0.00" value="{{ old('precio_venta') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Descripción <strong style="color:red;"></strong></label>
                                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Breve descripción del producto" required>{{ old('descripcion') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Stock <strong style="color:red;"></strong></label>
                                            <input type="number" class="form-control" name="stock" placeholder="Cantidad actual" value="{{ old('stock') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Stock Mínimo <strong style="color:red;"></strong></label>
                                            <input type="number" class="form-control" name="stock_minimo" placeholder="Alerta de stock" value="{{ old('stock_minimo') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Imagen del Producto</label>
                                            <input type="file" class="form-control" name="imagen" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="estado" value="Activo">
                                
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Guardar Producto</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('productos.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection