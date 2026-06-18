@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-3" style="border-top: 3px solid #6c757d;">
                <div class="card-header" style="background-color: #6c757d; color: white;">
                    <h3 class="card-title" style="font-size: 1.25rem; font-weight: 500;">
                        Editar Método de Pago: {{ $metodo_pago->tipo }}
                    </h3>
                </div>
                
                @include('layouts.partial.msg')

                <form action="{{ route('metodo_pagos.update', $metodo_pago->id) }}" method="POST">
                    @csrf
                    @method('PUT') 
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tipo" style="font-weight: 600; color: #333;">
                                Tipo de Pago <span style="color: red;"></span>
                            </label>
                            <input type="text" 
                                   name="tipo" 
                                   class="form-control" 
                                   value="{{ old('tipo', $metodo_pago->tipo) }}" 
                                   required>
                        </div>
                    </div>

                    <div class="card-footer" style="background-color: rgba(0,0,0,.03);">
                        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white; padding: .375rem .75rem;">
                            Actualizar Método
                        </button>
                        <a href="{{ route('metodo_pagos.index') }}" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545; color: white; margin-left: 5px; padding: .375rem .75rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection