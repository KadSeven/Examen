@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-3" style="border-top: 3px solid #6c757d;">
                <div class="card-header" style="background-color: #6c757d; color: white;">
                    <h3 class="card-title" style="font-size: 1.25rem; font-weight: 500;">
                        Editar Pago N°: {{ $pago->id }}
                    </h3>
                </div>
                
                @include('layouts.partial.msg')

                <form action="{{ route('pagos.update', $pago->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="factura_id" style="font-weight: 600; color: #333;">
                                        Factura Relacionada <span style="color: red;"></span>
                                    </label>
                                    <select name="factura_id" class="form-control" required>
                                        <option value="">-- Seleccione una Factura --</option>
                                        @foreach($facturas as $factura)
                                            <option value="{{ $factura->id }}" {{ old('factura_id', $pago->factura_id) == $factura->id ? 'selected' : '' }}>
                                                Factura N° {{ $factura->id }} - {{ $factura->cliente->nombre ?? 'Sin Cliente' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="monto" style="font-weight: 600; color: #333;">
                                        Monto del Pago <span style="color: red;"></span>
                                    </label>
                                    <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto', $pago->monto) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="metodo_pago_id" style="font-weight: 600; color: #333;">
                                        Método de Pago <span style="color: red;"></span>
                                    </label>
                                    <select name="metodo_pago_id" class="form-control" required>
                                        <option value="">-- Seleccione un Método --</option>
                                        @foreach($metodos as $metodo)
                                            <option value="{{ $metodo->id }}" {{ old('metodo_pago_id', $pago->metodo_pago_id) == $metodo->id ? 'selected' : '' }}>
                                                {{ $metodo->tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_pago" style="font-weight: 600; color: #333;">
                                        Fecha de Pago <span style="color: red;"></span>
                                    </label>
                                    <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', $pago->fecha_pago) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" style="background-color: rgba(0,0,0,.03);">
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white; padding: .375rem .75rem;">
                            Actualizar Pago
                        </button>
                        <a href="{{ route('pagos.index') }}" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545; color: white; margin-left: 5px; padding: .375rem .75rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection