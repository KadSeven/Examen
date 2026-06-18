@extends('layouts.app')

@section('title','Papelera de Métodos de Pago')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">@yield('title')</h3>
                    <a href="{{ route('metodo_pagos.index') }}" class="btn btn-secondary float-right">Volver</a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($metodo_pagos as $metodo)
                            <tr>
                                <td>{{ $metodo->id }}</td>
                                <td>{{ $metodo->tipo }}</td>
                                <td>
                                    <form action="{{ route('metodo_pagos.restaurar', $metodo->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-undo"></i> Restaurar
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
    </section>
</div>
@endsection