@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-3" style="border-top: 3px solid #6c757d;">
                <div class="card-header" style="background-color: #6c757d; color: white;">
                    <h3 class="card-title" style="font-size: 1.25rem; font-weight: 500;">
                        Editar Cliente: {{ $cliente->nombre }}
                    </h3>
                </div>
                
                @include('layouts.partial.msg')

                <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #333;">Nombre Completo <span style="color: red;"></span></label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #333;">Documento / Cédula <span style="color: red;"></span></label>
                                    <input type="text" name="documento" class="form-control" value="{{ old('documento', $cliente->documento) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #333;">Teléfono <span style="color: red;"></span></label>
                                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #333;">Correo Electrónico <span style="color: red;"></span></label>
                                    <input type="email" name="correo" class="form-control" value="{{ old('correo', $cliente->correo) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #333;">Dirección <span style="color: red;"></span></label>
                                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                </div>
                        </div>
                    </div>

                    <div class="card-footer" style="background-color: rgba(0,0,0,.03);">
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white; padding: .375rem .75rem;">
                            Actualizar Datos
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545; color: white; margin-left: 5px; padding: .375rem .75rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection