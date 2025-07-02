<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Entrega Consumibles No. {{ $entrega->id }}</title>
  <style>
    @page {
      margin: 0cm;
      size: A4;
    }
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-size: 10px;
      width: 100%;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 4px;
      white-space: nowrap;
    }
    .descripcion {
      white-space: normal;
      word-wrap: break-word;
      word-break: break-word;
      max-width: 200px;
    }
    .firma-final {
      position: absolute;
      bottom: 50px; /* puedes ajustar más abajo si deseas */
      width: 100%;
      text-align: center;
    }
    .text-center { text-align: center; }
    .text-end { text-align: right; }
    .d-flex { display: flex; justify-content: space-between; }
    .mt-3 { margin-top: 1rem; }
    .mt-4 { margin-top: 1.5rem; }
    .mt-5 { margin-top: 3rem; }
  </style>
</head>
<body>
  <div style="width: 100%; padding: 0; margin: 0;">
    <!-- Encabezado -->
    <table style="border: 1px solid #ccc;">
      <tr>
        <td rowspan="3" style="width: 40%; text-align: center; vertical-align: middle; border-right: 1px solid #ccc;">
          <img src="{{ public_path('NiceAdmin/assets/img/GrupoVysisaLogo.png') }}" alt="Logo Vysisa" style="width: 45%; max-height: 120px;">
        </td>
        <td style="width: 60%; text-align: center; font-size: 18px; font-weight: bold; border-bottom: 1px solid #ccc;">
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

    <!-- Datos principales -->
    <table style="margin-top: 10px;">
      <tr>
        <td><strong>No. Salida:</strong> SEC-{{ str_pad($entrega->id, 6, '0', STR_PAD_LEFT) }}</td>
        <td><strong>Usuario:</strong> {{ $entrega->colaborador->nombre }} {{ $entrega->colaborador->apellido }}</td>
      </tr>
      <tr>
        <td><strong>Equipo:</strong> CARTUCHO</td>
        <td><strong>Fecha:</strong> {{ $entrega->fecha_entrega }}</td>
      </tr>
      <tr>
        <td><strong>Unidad de servicio:</strong> {{ $entrega->unidad }}</td>
        <td><strong>Realizó:</strong> {{ $entrega->entrego->name ?? '-' }}</td>
      </tr>
    </table>

    <!-- Productos -->
    <p class="mt-3"><strong>Consumibles entregados:</strong></p>
    <table>
      <thead>
        <tr class="text-center">
          <th>CANTIDAD</th>
          <th>NOMBRE</th>
          <th>DESCRIPCIÓN</th>
          <th>MARCA</th>
          <th>MODELO</th>
          <th>NO. SERIE</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($entrega->productos as $producto)
        <tr class="text-center">
          <td>{{ $producto->pivot->cantidad_asignada }}</td>
          <td>{{ $producto->nombre }}</td>
          <td class="descripcion">{{ $producto->descripcion }}</td>
          <td>{{ $producto->marca }}</td>
          <td>{{ $producto->modelo }}</td>
          <td>{{ $producto->no_serie }}</td>
        </tr>
        @endforeach
        @for ($i = 0; $i < max(0, 5 - $entrega->productos->count()); $i++)
        <tr style="height: 40px;" class="text-center">
          <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td>
        </tr>
        @endfor
      </tbody>
    </table>

    <!-- Campo: Solicitud(es) -->
<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <tr>
      <td style="height: 80px; vertical-align: top; border: 1px solid #ccc; padding: 6px;">
        <strong>Solicitud(es):</strong>
      </td>
    </tr>
  </table>
  
  <!-- Campo: Recomendaciones -->
  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
      <td style="height: 80px; vertical-align: top; border: 1px solid #ccc; padding: 6px;">
        <strong>Recomendaciones:</strong>
      </td>
    </tr>
  </table>
  
  <!-- Campo: Observaciones -->
  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
      <td style="height: 50px; vertical-align: top; border: 1px solid #ccc; padding: 6px;">
        <strong>Observaciones:</strong>
      </td>
    </tr>
  </table>
  

    <!-- Firma al pie de la hoja -->
    <div class="firma-final">
    @php
      $firmaRecibio = public_path('storage/firmas/' . ($entrega->recibio?->nombre ?? '') . '.jpg');
    @endphp
  
    @if(file_exists($firmaRecibio))
      <img src="{{ asset('storage/firmas/' . $entrega->recibio?->nombre . '.jpg') }}" alt="Firma" style="max-height: 60px;">
    @else
      <div style="height: 60px;"></div>
    @endif
  
    <p style="margin: 5px 0 2px 0; font-size: 14px;">
      {{ $entrega->recibio?->nombre }} {{ $entrega->recibio?->apellido }}
    </p>
    <hr style="width: 50%; margin: 0 auto;">
    <p style="font-size: 11px; margin-top: 4px;">NOMBRE Y FIRMA DE CONFORMIDAD DEL USUARIO</p>
  </div>
  
  </div>
</body>
</html>
