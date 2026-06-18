@extends('layouts.app')

@section('title', 'Registrar Pago')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Pago</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Formulario de Registro</h3>
                        </div>
                        
                        <form action="{{ route('pagos.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="factura_id">Factura (Cliente)</label>
                                            <select name="factura_id" class="form-control select2" required>
                                                <option value="">Seleccione una factura...</option>
                                                @foreach($facturas as $factura)
                                                    <option value="{{ $factura->id }}">
                                                        {{ $factura->cliente->nombre }} (Total: ${{ number_format($factura->total, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="metodo_pago_id">Método de pago</label>
                                            <select name="metodo_pago_id" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($metodos as $metodo)
                                                    <option value="{{ $metodo->id }}">{{ $metodo->tipo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="monto">Monto a pagar</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                </div>
                                                <input type="number" step="0.01" name="monto" class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto') }}" required>
                                                    @error('monto')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_pago">Fecha de pago</label>
                                            <input type="date" name="fecha_pago" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <a href="{{ route('pagos.index') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Pago</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection