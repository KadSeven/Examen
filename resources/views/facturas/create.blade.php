@extends('layouts.app')

@section('content')
{{-- ESTILOS DEL CALENDARIO (Metidos a la fuerza aquí para que funcionen sí o sí) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-input[readonly] {
        background-color: #ffffff !important;
    }
    .input-group-text {
        cursor: pointer;
    }
    /* Estilo para asegurar que el calendario flote por encima de todo y no se esconda */
    .flatpickr-calendar {
        z-index: 99999 !important;
    }
</style>

<div class="content-wrapper" style="margin-left: 260px; padding: 20px; min-height: 100vh; background-color: #f8f9fa;">
    <div class="container-fluid">
        
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <strong><i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white py-3">
                <h3 class="mb-0" style="font-size: 20px; font-weight: 600;">Crear Factura</h3>
            </div>
            <div class="card-body p-4">
                
                <form action="{{ route('facturas.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="estado" value="1">
                    <input type="hidden" name="registrado_por" value="Sistema">

                    {{-- FILA 1: DATOS PRINCIPALES --}}
                    <div class="row g-3 mb-4 align-items-end">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label"><strong>Cliente</strong></label>
                                <select name="cliente_id" class="form-control select2-cliente" required style="width: 100%;">
                                    <option value="">Escribe para buscar un cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_venta" class="form-label"><strong>Tipo de Venta</strong></label>
                                <select name="tipo_venta" id="tipo_venta" class="form-control" required>
                                    <option value="">Seleccione tipo</option>
                                    <option value="Contado" {{ old('tipo_venta') == 'Contado' ? 'selected' : '' }}>Contado</option>
                                    <option value="Credito" {{ old('tipo_venta') == 'Credito' ? 'selected' : '' }}>Crédito</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="metodo_pago_id" class="form-label"><strong>¿Con qué método?</strong></label>
                                <select name="metodo_pago_id" id="metodo_pago_id" class="form-control select2-metodo" required style="width: 100%;">
                                    <option value="">Seleccione pago</option>
                                    @foreach($metodos_pago as $metodo)
                                        <option value="{{ $metodo->id }}" {{ old('metodo_pago_id') == $metodo->id ? 'selected' : '' }}>
                                            {{ $metodo->tipo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- EL CAMPO DEL CALENDARIO --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha" class="form-label"><strong>Fecha de Emisión</strong></label>
                                <div class="input-group" id="flatpickr_wrapper">
                                    <input type="text" name="fecha" id="fecha_input" class="form-control" 
                                           value="{{ old('fecha', date('d/m/Y')) }}" 
                                           placeholder="DD/MM/AAAA" required data-input>
                                    <span class="input-group-text bg-light text-muted" data-toggle>
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    {{-- SECCIÓN INTERACTIVA: AGREGAR PRODUCTOS --}}
                    <h5 class="text-primary mb-3"><i class="fas fa-cart-plus"></i> Agregar Productos al Detalle</h5>
                    <div class="row g-3 mb-4 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label">Producto</label>
                            <select id="select_producto" class="form-control select2-producto">
                                <option value="">Seleccione un producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}">
                                        {{ $producto->nombre }} (${{ number_format($producto->precio_venta, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" id="input_cantidad" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="btn_agregar" class="btn btn-dark w-100">
                                <i class="fas fa-plus"></i> Agregar al Detalle
                            </button>
                        </div>
                    </div>

                    {{-- TABLA DINÁMICA DE DETALLES --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped vertical-align-middle" id="tabla_detalles">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th style="width: 15%;">Cantidad</th>
                                    <th style="width: 20%;">Precio Unitario</th>
                                    <th style="width: 20%;">Subtotal</th>
                                    <th style="width: 10%;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Contenido dinámico --}}
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-4">

                    {{-- FILA 3: TOTALES --}}
                    <div class="row g-3 mb-4 align-items-end">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input_total" class="form-label"><strong>Total ($)</strong></label>
                                <input type="number" name="total" id="input_total" class="form-control" value="0.00" step="0.01" readonly style="background-color: #e9ecef; font-weight: bold;">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input_abono" class="form-label"><strong>Monto a Abonar ($)</strong></label>
                                <input type="number" name="monto_abono" id="input_abono" class="form-control" value="0.00" step="0.01" min="0" readonly style="background-color: #e9ecef;">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input_saldo" class="form-label"><strong>Saldo Pendiente ($)</strong></label>
                                <input type="number" name="saldopendiente" id="input_saldo" class="form-control" value="0.00" step="0.01" readonly style="background-color: #e9ecef; font-weight: bold;">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4 me-2">Generar Factura</button>
                        <a href="{{ route('facturas.index') }}" class="btn btn-danger px-4">Atrás</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- MOTOR DEL CALENDARIO (Inyectado directo aquí para asegurar que funcione) --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
// Usamos una función de chequeo continuo por si JQuery tarda en cargar en tu layout
function inicializarTodo() {
    
    // 1. ACTIVAR EL CALENDARIO SÍ O SÍ
    if (typeof flatpickr !== 'undefined') {
        flatpickr("#flatpickr_wrapper", {
            wrap: true,             
            locale: "es",           
            dateFormat: "d/m/Y",    
            allowInput: true        
        });
    }

    // Lógica de productos e interfaz
    const btnAgregar = document.getElementById('btn_agregar');
    const selectProducto = document.getElementById('select_producto');
    const inputCantidad = document.getElementById('input_cantidad');
    const tablaDetalles = document.getElementById('tabla_detalles').getElementsByTagName('tbody')[0];
    
    const selectTipoVenta = document.getElementById('tipo_venta');
    const inputTotal = document.getElementById('input_total');
    const inputAbono = document.getElementById('input_abono');
    const inputSaldo = document.getElementById('input_saldo');

    let totalFactura = 0;

    function actualizarTotales() {
        if (inputTotal) {
            let totalLimpio = parseFloat(totalFactura) || 0;
            inputTotal.value = totalLimpio.toFixed(2);
        }
        
        let tipoVenta = selectTipoVenta ? selectTipoVenta.value.trim() : '';
        
        if (tipoVenta === 'Credito' || tipoVenta === 'Crédito') {
            inputAbono.removeAttribute('readonly');
            inputAbono.style.backgroundColor = "#ffffff";
            
            let abonoTexto = inputAbono.value.replace(',', '.');
            let abono = parseFloat(abonoTexto) || 0;
            
            if (abono > totalFactura) {
                alert("El abono no puede ser mayor al total de la factura.");
                inputAbono.value = totalFactura.toFixed(2);
                abono = totalFactura;
            }
            
            let saldoRestante = totalFactura - abono;
            inputSaldo.value = saldoRestante.toFixed(2);
        } else {
            inputAbono.setAttribute('readonly', true);
            inputAbono.style.backgroundColor = "#e9ecef";
            inputAbono.value = totalFactura.toFixed(2);
            inputSaldo.value = "0.00";
        }
    } 

    if (selectTipoVenta) {
        selectTipoVenta.addEventListener('change', function() {
            if (this.value === 'Credito' || this.value === 'Crédito') {
                inputAbono.value = "0.00"; 
            }
            actualizarTotales();
        });
    }

    if (inputAbono) {
        inputAbono.addEventListener('input', actualizarTotales);
    }

    if (btnAgregar) {
        btnAgregar.onclick = function() {
            const productoId = selectProducto.value;
            const selectedOption = selectProducto.options[selectProducto.selectedIndex];
            
            if (!productoId) {
                alert("Por favor, seleccione un producto válido de la lista.");
                return;
            }

            const precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
            const cantidad = parseInt(inputCantidad.value) || 1;

            if (cantidad <= 0) {
                alert("La cantidad ingresada debe ser mayor a 0.");
                return;
            }

            const subtotal = precio * cantidad;
            const productoNombre = selectedOption.text.split(' ($')[0];

            const nuevaFila = tablaDetalles.insertRow();
            nuevaFila.innerHTML = `
                <td>
                    <input type="hidden" name="productos[]" value="${productoId}">
                    ${productoNombre}
                </td>
                <td>
                    <input type="hidden" name="cantidades[]" value="${cantidad}">
                    ${cantidad}
                </td>
                <td>
                    <input type="hidden" name="precios[]" value="${precio}">
                    $${precio.toFixed(2)}
                </td>
                <td class="subtotal-celda">$${subtotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar"><i class="fas fa-trash"></i></button>
                </td>
            `;

            totalFactura += subtotal;
            actualizarTotales();

            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-producto').val('').trigger('change');
            } else {
                selectProducto.value = "";
            }
            inputCantidad.value = 1;
        };
    }

    if (tablaDetalles) {
        tablaDetalles.onclick = function(e) {
            if (e.target.classList.contains('btn-eliminar') || e.target.closest('.btn-eliminar')) {
                const fila = e.target.closest('tr');
                const textoSubtotal = fila.querySelector('.subtotal-celda').textContent.replace('$', '').replace(/,/g, '').trim();
                const subtotalFila = parseFloat(textoSubtotal) || 0;
                
                totalFactura -= subtotalFila;
                if (totalFactura < 0) totalFactura = 0;
                
                fila.remove();
                actualizarTotales(); 
            }
        };
    }

    // Inicializar Select2 solo si la librería de JQuery ya respondió
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('.select2-cliente').select2({
            theme: 'bootstrap4',
            placeholder: 'Escribe para buscar un cliente...',
            allowClear: true,
            language: { noResults: function() { return "No se encontraron resultados"; } }
        });

        $('.select2-producto').select2({
            theme: 'bootstrap4',
            placeholder: 'Escribe para buscar un producto...',
            allowClear: true,
            language: { noResults: function() { return "No se encontraron resultados"; } }
        });

        $('.select2-metodo').select2({
            theme: 'bootstrap4',
            placeholder: 'Seleccione pago',
            allowClear: true,
            language: { noResults: function() { return "No se encontraron resultados"; } }
        });
    }
}

// Ejecutar inmediatamente y asegurar carga limpia
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", inicializarTodo);
} else {
    inicializarTodo();
}
</script>
@endsection