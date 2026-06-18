@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary mt-3">
                <div class="card-header">
                    <h3 class="card-title">Nuevo Método de Pago</h3>
                </div>
                
                @include('layouts.partial.msg')

                <form action="{{ route('metodo_pagos.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tipo">Tipo de Pago</label>
                            <input type="text" name="tipo" class="form-control" placeholder="Ej: PayPal" value="{{ old('tipo') }}" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Método</button>
                        <a href="{{ route('metodo_pagos.index') }}" class="btn btn-danger">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection