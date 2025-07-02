@extends('layouts.main')

@section('titulo', 'Entrega de Consumibles No. ' . $entrega->id)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Solicitud y Entrega de Consumibles</h1>
  </div>

  <section class="section">
    <div class="container bg-white p-4" style="font-family: Arial, sans-serif; border:1px solid #ccc;">

      <!-- ENCABEZADO -->
      <table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">
        <tr>
          <td rowspan="3" style="width: 40%; text-align: center; vertical-align: middle; border-right: 1px solid #ccc;">
            <img src="{{ asset('NiceAdmin/assets/img/GrupoVysisaLogo.png') }}" alt="Logo Vysisa" style="width: 45%; max-height: 100px;">
          </td>
          <td style="text-align: center; font-size: 20px; font-weight: bold; border-bottom: 1px solid #ccc;">
            Grupo VYSISA
          </td>
        </tr>
        <tr>
          <td style="text-align: center; font-size: 13px; border-bottom: 1px solid #ccc;">
            DEPARTAMENTO DE GESTION INFORMATICA
          </td>
        </tr>
        <tr>
          <td style="text-align: center; font-size: 16px; font-weight: bold;">
            SOLICITUD Y ENTREGA DE CARTUCHOS
          </td>
        </tr>
      </table>

      <!-- INFORMACION PRINCIPAL -->
      <table style="width: 100%; margin-top: 20px; border: 1px solid #ccc; border-collapse: collapse;">
        <tr>
          <td style="padding: 6px; border: 1px solid #ccc;"><strong>No. Salida:</strong> SEC-{{ str_pad($entrega->id, 6, '0', STR_PAD_LEFT) }}</td>
          <td style="padding: 6px; border: 1px solid #ccc;"><strong>Usuario:</strong> {{ $entrega->colaborador->nombre }} {{ $entrega->colaborador->apellido }}</td>
        </tr>
        <tr>
          <td style="padding: 6px; border: 1px solid #ccc;"><strong>Equipo:</strong> CARTUCHO</td>
          <td style="padding: 6px; border: 1px solid #ccc;"><strong>Fecha:</strong> {{ $entrega->fecha_entrega }}</td>
        </tr>
        <tr>
          <td style="padding: 6px; border: 1px solid #ccc;"><strong>Unidad de servicio:</strong> {{ $entrega->unidad }}</td>
          <td style="padding: 6px; border: 1px solid #ccc;"><strong>Realizó:</strong> {{ $entrega->entrego->name ?? '-' }}</td>
        </tr>
      </table>

      <br>

      <!-- TABLA DE PRODUCTOS -->
      <p class="mt-4"><strong>Consumibles entregados:</strong></p>
      <table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">
        <thead>
          <tr class="text-center">
            <th style="border: 1px solid #ccc; padding: 6px;">Cantidad</th>
            <th style="border: 1px solid #ccc; padding: 6px;">Nombre</th>
            <th style="border: 1px solid #ccc; padding: 6px;">Descripción</th>
            <th style="border: 1px solid #ccc; padding: 6px;">Marca</th>
            <th style="border: 1px solid #ccc; padding: 6px;">Modelo</th>
            <th style="border: 1px solid #ccc; padding: 6px;">No. Serie</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($entrega->productos as $producto)
            <tr class="text-center">
              <td style="border: 1px solid #ccc; padding: 6px;">{{ $producto->pivot->cantidad_asignada }}</td>
              <td style="border: 1px solid #ccc; padding: 6px;">{{ $producto->nombre }}</td>
              <td style="border: 1px solid #ccc; padding: 6px;">{{ $producto->descripcion }}</td>
              <td style="border: 1px solid #ccc; padding: 6px;">{{ $producto->marca }}</td>
              <td style="border: 1px solid #ccc; padding: 6px;">{{ $producto->modelo }}</td>
              <td style="border: 1px solid #ccc; padding: 6px;">{{ $producto->no_serie }}</td>
            </tr>
          @endforeach
          @for ($i = 0; $i < max(0, 5 - $entrega->productos->count()); $i++)
            <tr style="height: 40px;">
              <td style="border: 1px solid #ccc;">&nbsp;</td>
              <td style="border: 1px solid #ccc;">&nbsp;</td>
              <td style="border: 1px solid #ccc;">&nbsp;</td>
              <td style="border: 1px solid #ccc;">&nbsp;</td>
              <td style="border: 1px solid #ccc;">&nbsp;</td>
              <td style="border: 1px solid #ccc;">&nbsp;</td>
            </tr>
          @endfor
        </tbody>
      </table>

      <!-- CAMPOS EXTRA -->
      <br>
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td style="height: 80px; border: 1px solid #ccc; vertical-align: top; padding: 6px;"><strong>Solicitud(es):</strong></td>
        </tr>
      </table>
      <br>
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td style="height: 80px; border: 1px solid #ccc; vertical-align: top; padding: 6px;"><strong>Recomendaciones:</strong></td>
        </tr>
      </table>
      <br>
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td style="height: 50px; border: 1px solid #ccc; vertical-align: top; padding: 6px;"><strong>Observaciones:</strong></td>
        </tr>
      </table>

      <!-- FIRMA -->
      <div class="text-center mt-5">
        @php
          $firmaRecibio = public_path('storage/firmas/' . ($entrega->recibio?->nombre ?? '') . '.jpg');
        @endphp
        @if(file_exists($firmaRecibio))
          <img src="{{ asset('storage/firmas/' . $entrega->recibio?->nombre . '.jpg') }}" alt="Firma" style="max-height: 60px;">
        @else
          <div style="height: 60px;"></div>
        @endif
        <p style="margin: 0; padding: 0; font-weight: normal;">{{ $entrega->recibio?->nombre }} {{ $entrega->recibio?->apellido }}</p>
        <hr style="width: 40%; margin: 0 auto;">
        <p style="font-size: 13px; margin-top: 2px;">NOMBRE Y FIRMA DE CONFORMIDAD DEL USUARIO</p>
      </div>

      <div class="text-end mt-4">
        <a href="{{ request()->query('from') === 'consulta' 
                     ? route('consulta_entrega_cartuchos') 
                     : route('entrega_cartuchos.index') }}" 
           class="btn btn-secondary">
          Volver
        </a>
      
        <a href="{{ route('entrega_cartuchos.edit', [
            'id' => $entrega->id, 
            'from' => request()->query('from'), 
            'back' => 'show'
        ]) }}" class="btn btn-primary">
          Editar
        </a>
      
        <a href="{{ route('entrega_cartuchos.pdf', $entrega->id) }}" class="btn btn-dark" target="_blank">
          Descargar PDF
        </a>
      </div>
    </div>
  </section>
</main>
@endsection
