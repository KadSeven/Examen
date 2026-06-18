@extends('layouts.app')

@section('title','Listado de Métodos de Pago')

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
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            
                            <a href="{{ route('metodo_pagos.create') }}" class="btn btn-primary float-right" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
                            
                            <a href="{{ route('metodo_pagos.papelera') }}" class="btn btn-warning float-right mr-2" title="Ver Borrados">
                                <i class="fas fa-trash nav-icon"></i> Papelera
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <th width="10px">ID</th>
                                    <th>Tipo</th>
                                    <th width="60px">Estado</th>
                                    <th width="90px">Acción</th>
                                </thead>
                                <tbody>
                                    @foreach($metodo_pagos as $metodo)
                                    <tr>
                                        <td>{{ $metodo->id }}</td>
                                        <td>{{ $metodo->tipo }}</td>
                                        <td>
                                            <input data-type="metodo_pagos" data-id="{{$metodo->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
                                                data-toggle="toggle" data-on="Disponible" data-off="No Disponible" {{ $metodo->estado ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <a href="{{ route('metodo_pagos.edit', $metodo->id) }}" class="btn btn-info btn-sm" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                            <form class="d-inline delete-form" action="{{ route('metodo_pagos.destroy', $metodo) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Desea mover este método a la papelera?')">
                                                    <i class="fas fa-trash-alt"></i>
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