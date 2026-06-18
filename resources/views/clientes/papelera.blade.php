@extends('layouts.app')

@section('title','Papelera de Clientes')

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
                        <div class="card-header bg-dark" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary float-right" title="Volver al listado">
                                <i class="fas fa-arrow-left nav-icon"></i> Volver
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <th width="10px">ID</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th width="90px">Acción</th>
                                </thead>
                                <tbody>
                                    @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->id }}</td>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->documento }}</td>
                                        <td>{{ $cliente->telefono }}</td>
                                        <td>{{ $cliente->correo }}</td>
                                        <td>
                                            <form action="{{ route('clientes.restaurar', $cliente->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Restaurar Cliente"
                                                    onclick="return confirm('¿Desea restaurar este cliente?')">
                                                    <i class="fas fa-undo-alt"></i> Restaurar
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