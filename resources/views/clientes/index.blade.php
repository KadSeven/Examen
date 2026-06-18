@extends('layouts.app')

@section('title','Listado de Clientes')

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
							
								<a href="{{ route('clientes.create') }}" class="btn btn-primary float-right ml-2" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
    
    <a href="{{ route('clientes.papelera') }}" class="btn btn-warning float-right" title="Ver Borrados">
        <i class="fas fa-trash nav-icon"></i> Papelera
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
									<th>Direccion</th>
									<th width="60px">Estado</th>
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
										<td>{{ $cliente->direccion }}</td>
										
										<td>
											<input data-type="cliente" data-id="{{$cliente->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
												data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $cliente->estado ? 'checked' : '' }}>
												</td>
										</td>
										<td>
										
											<a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-info btn-sm" title="Editar">
												<i class="fas fa-pencil-alt"></i>
											</a>
										
										
											<form class="d-inline delete-form" action="{{ route('clientes.destroy', $cliente) }}"  method="POST">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger btn-sm" title="Eliminar"
													onclick="return confirm('¿Está seguro de eliminar este cliente?')">
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