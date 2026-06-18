@extends('layouts.app')

@section('title','Crear Cliente')

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
                        <form method="POST" action="{{ route('clientes.store') }}">
                            @csrf
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Nombre <strong style="color:red;"></strong></label>
                                            <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" value="{{ old('nombre') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Documento <strong style="color:red;"></strong></label>
                                            <input type="text" class="form-control" name="documento" placeholder="Cédula o NIT" value="{{ old('documento') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Teléfono <strong style="color:red;"></strong></label>
                                            <input type="text" class="form-control" name="telefono" placeholder="Número de contacto" value="{{ old('telefono') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Correo Electrónico <strong style="color:red;"></strong></label>
                                            <input type="email" class="form-control" name="correo" placeholder="ejemplo@correo.com" value="{{ old('correo') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Dirección <strong style="color:red;"></strong></label>
                                            <input type="text" class="form-control" name="direccion" placeholder="Dirección de residencia" value="{{ old('direccion') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="estado" value="1">
                                <input type="hidden" name="registrado_por" value="{{ Auth::user()->id }}">
                                
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('clientes.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
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