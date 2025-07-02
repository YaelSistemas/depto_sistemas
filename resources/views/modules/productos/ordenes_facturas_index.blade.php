@extends('layouts.main') 

@section('titulo', 'Órdenes de Compra y Facturas')

@section('contenido')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Órdenes de Compra y Facturas</h1>
    </div>
    
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title">Listado de Productos con Documentos</h5>
                
                @php use Illuminate\Support\Collection; use Illuminate\Support\Str; @endphp
                
                @php
                    $ordenesAgrupadas = collect();
                    foreach ($productos as $producto) {
                        $mesCompra = optional($producto->fecha_compra)
                        ? \Carbon\Carbon::parse($producto->fecha_compra)->format('Y-m')
                        : 'Sin fecha';
                        
                        foreach ($producto->documentos_orden as $orden) {
                            $clave = $mesCompra . '|' . $orden->archivo;
                            
                            if (!$ordenesAgrupadas->has($clave)) {
                                $ordenesAgrupadas->put($clave, [
                                    'mes' => $mesCompra,
                                    'orden' => $orden,
                                    'facturas' => collect(),
                                    'productos' => collect(),
                                ]);
                            }
                            
                            $ordenesAgrupadas[$clave]['productos']->put($producto->id, $producto);
                            foreach ($producto->documentos_factura as $factura) {
                                $ordenesAgrupadas[$clave]['facturas']->put($factura->archivo, $factura);
                            }
                        }
                    }
                    $agrupadasPorMes = $ordenesAgrupadas->groupBy('mes');
                @endphp
                
                @if ($ordenesAgrupadas->isNotEmpty())
                <table class="table table-bordered table-hover table-documentos">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-center align-middle">Productos Relacionados</th>
                            <th class="text-center align-middle">Fecha de Compra</th>
                            <th class="text-center align-middle">Orden de Compra</th>
                            <th class="text-center align-middle">Facturas PDF</th>
                            <th class="text-center align-middle">Facturas XML</th>
                        </tr>
                    </thead>
                    
                    @foreach ($agrupadasPorMes as $mes => $items)
                    <thead class="table-primary text-center fw-bold">
                        <tr>
                            <th colspan="6" class="text-center">
                                {{ $mes !== 'Sin fecha' ? \Carbon\Carbon::parse($mes . '-01')->translatedFormat('F Y') : 'Sin fecha de compra' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
<td class="align-middle">
  <ul class="mb-0 ps-3">
    @foreach ($item['productos'] as $producto)
      @php
        $nombreLower = strtolower($producto->nombre);
        $esCartucho = Str::contains($nombreLower, ['cartucho', 'tóner', 'tinta', 'toner']);
        $responsiva = !$esCartucho ? $producto->responsivas()->first() : null;
        $totalAsignadas = $esCartucho && $producto->entregas_cartuchos ? 
    $producto->entregas_cartuchos->sum('pivot.cantidad_asignada') : 0;

        $totalDisponibles = $producto->cantidad;
      @endphp
      <li class="d-flex justify-content-between align-items-center gap-2">
        <span>{{ $producto->nombre }}</span>
        <span>
          @if ($esCartucho && $totalAsignadas >= $totalDisponibles)
    @foreach ($producto->entregas_cartuchos as $entrega)
        <a href="{{ route('entrega_cartuchos.show', ['id' => $entrega->id, 'from' => 'consulta']) }}"
           class="badge bg-info text-decoration-none d-inline-block mb-1" title="Fecha: {{ $entrega->fecha_entrega }}">
            Entregado ({{ $entrega->folio ?? 'ID ' . $entrega->id }})
        </a>
    @endforeach
          @elseif ($esCartucho && $totalAsignadas > 0)
            <span class="badge bg-warning text-dark">Parcial</span>
          @elseif ($esCartucho)
            <span class="badge bg-secondary">No asignado</span>
          @elseif ($responsiva)
            <a href="{{ route('responsivas.show', $responsiva->id) }}" class="badge bg-success text-decoration-none">Asignado</a>
          @else
            <span class="badge bg-secondary">No asignado</span>
          @endif
        </span>
      </li>
    @endforeach
  </ul>
</td>
                                <td class="text-center align-middle">
                                    @php
                                        $fechas = $item['productos']->keys()->map(fn($id) => optional($productos->firstWhere('id', $id))->fecha_compra)
                                        ->filter()
                                        ->map(fn($f) => \Carbon\Carbon::parse($f)->format('Y-m-d'))
                                        ->unique()
                                        ->values();
                                    @endphp
                                    @if ($fechas->isEmpty())
                                        <span class="text-muted">No definida</span>
                                    @elseif ($fechas->count() === 1)
                                        {{ $fechas->first() }}
                                    @else
                                    <ul class="mb-0 ps-3">
                                        @foreach ($fechas as $fecha)
                                            <li>{{ $fecha }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ asset('storage/' . $item['orden']->archivo) }}" target="_blank" class="d-block">
                                        📄 {{ basename($item['orden']->archivo) }}
                                    </a>
                                </td>
                                <td class="text-center align-middle">
                                    @forelse ($item['facturas']->filter(fn($f) => Str::endsWith($f->archivo, '.pdf')) as $factura)
                                        <a href="{{ asset('storage/' . $factura->archivo) }}" target="_blank" class="d-block">
                                            📄 {{ basename($factura->archivo) }}
                                        </a>
                                            @empty
                                                <span class="text-muted">Sin PDF</span>
                                    @endforelse
                                </td>
                                <td class="text-center align-middle">
                                    @forelse ($item['facturas']->filter(fn($f) => Str::endsWith($f->archivo, '.xml')) as $factura)
                                        <a href="{{ asset('storage/' . $factura->archivo) }}" target="_blank" class="d-block">
                                            📄 {{ basename($factura->archivo) }}
                                        </a>
                                            @empty
                                                <span class="text-muted">Sin XML</span>
                                    @endforelse
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endforeach
                </table>
                
                @else
                <div class="alert alert-info">No hay órdenes de compra registradas.</div>
                @endif
      </div>
    </div>
  </section>
</main>

@push('scripts')
<script>
  $(document).ready(function () {
    $('.table-documentos').DataTable({
      paging: true,
      searching: true,
      info: true,
      ordering: false,
      language: {
        search: "Buscar:",
        lengthMenu: "Mostrar _MENU_ registros",
        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
        infoEmpty: "Mostrando 0 a 0 de 0 registros",
        zeroRecords: "No se encontraron resultados",
        paginate: {
          first: "Primero",
          last: "Último",
          next: "Siguiente",
          previous: "Anterior"
        }
      },
    });
  });
</script>
@endpush

@endsection
