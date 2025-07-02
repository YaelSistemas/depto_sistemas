<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responsiva No. {{ $responsiva->id }}</title>
    <style>
      @@page {
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

    td.descripcion {
        white-space: normal;
        word-wrap: break-word;
        word-break: break-word;
        max-width: 200px; /* o ajusta según tu layout */
      }

    .text-center {
        text-align: center;
    }

    .text-end {
        text-align: right;
    }

    .d-flex {
        display: flex;
        justify-content: space-between;
    }

    .mt-3 {
        margin-top: 1rem;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .mt-5 {
        margin-top: 3rem;
    }

    .motivo-label {
        font-size: 9px;
        display: inline-block;
        margin: 0 6px;
        vertical-align: middle;
    }

    .checkbox-align {
        vertical-align: middle;
        margin-left: 2px;
    }
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
          DEPARTAMENTO DE SISTEMAS
        </td>
      </tr>
      <tr>
        <td style="text-align: center; font-size: 16px; font-weight: bold;">
          FORMATO DE RESPONSIVA
        </td>
      </tr>
    </table>
    
    <br>

    <!-- Datos principales -->
    <table style="width: 100%; table-layout: fixed; border-collapse: collapse; font-size: 10px; border: 1px solid #ccc;">
      <tr>
        {{-- NO. DE SALIDA --}}
        <td style="padding: 0; width: 25%; border: 1px solid #ccc;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 45%; padding: 4px; border-right: 1px solid #ccc; border-top: none; border-bottom: none; border-left: none;">
                <strong>No. DE SALIDA:</strong>
              </td>
              <td style="width: 55%; padding: 4px; text-align: center; border-left: 1px solid #ccc; border-top: none; border-bottom: none; border-right: none;">
                OES-{{ str_pad($responsiva->id, 5, '0', STR_PAD_LEFT) }}
              </td>
            </tr>
          </table>
        </td>
    
        {{-- FECHA DE SOLICITUD --}}
        <td style="padding: 0; width: 25%; border: 1px solid #ccc;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 45%; padding: 4px; border-right: 1px solid #ccc; border-top: none; border-bottom: none; border-left: none;">
                <strong>FECHA DE SOLICITUD:</strong>
              </td>
              <td style="width: 55%; padding: 4px; text-align: center; border-left: 1px solid #ccc; border-top: none; border-bottom: none; border-right: none;">
                {{ $responsiva->fecha_asignacion }}
              </td>
            </tr>
          </table>
        </td>
    
        {{-- NOMBRE DEL USUARIO --}}
        <td style="padding: 0; width: 50%; border: 1px solid #ccc;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 30%; padding: 4px; border-right: 1px solid #ccc; border-top: none; border-bottom: none; border-left: none;">
                <strong>NOMBRE DEL USUARIO:</strong>
              </td>
              <td style="width: 70%; padding: 4px; text-align: center; border-left: 1px solid #ccc; border-top: none; border-bottom: none; border-right: none;">
                {{ $responsiva->colaborador->nombre ?? '-' }} {{ $responsiva->colaborador->apellido ?? '' }}
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    

    <table style="width: 100%; table-layout: fixed; border-collapse: collapse; font-size: 10px; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; border-top: none;">
      <tr>
        {{-- ÁREA/DEPTO/SEDE --}}
        <td style="padding: 0; width: 40%; border: 1px solid #ccc;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 45%; padding: 4px; border-right: 1px solid #ccc; border-top: none; border-bottom: none; border-left: none;">
                <strong>ÁREA/DEPTO/SEDE:</strong>
              </td>
              <td style="width: 55%; padding: 4px; text-align: center; border-left: 1px solid #ccc; border-top: none; border-bottom: none; border-right: none;">
                {{ $responsiva->colaborador->unidadServicio->nombre ?? '-' }} -
                {{ $responsiva->colaborador->areaDepartamento->nombre ?? '-' }}
              </td>
            </tr>
          </table>
        </td>
        
        {{-- MOTIVO DE ENTREGA --}}
        <td style="padding: 0; width: 60%; border: 1px solid #ccc;">
          <table style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="width: 30%; padding: 4px; border-right: 1px solid #ccc; border-top: none; border-bottom: none; border-left: none;">
                <strong">MOTIVO DE ENTREGA:</strong>
              </td>
              <td style="width: 70%; padding: 4px; text-align: center; border-left: 1px solid #ccc; border-top: none; border-bottom: none; border-right: none;">
                @foreach (['Fallo', 'Prestamo Provisional', 'Asignacion'] as $motivo)
                <span style="
                font-size: 8px;
                margin: 4px 8px 0;
                display: inline-block;
                vertical-align: middle;
                padding-top: 2px;
                line-height: 1;">
                {{ strtoupper($motivo) }}
                <input type="checkbox"
                disabled
                style="vertical-align: middle; margin-left: 3px;"
                {{ $responsiva->motivo_entrega === $motivo ? 'checked' : '' }}>
              </span>
              @endforeach
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <br><br><br><br>

    <p>
      Por medio de la presente hago constar que: Se hace entrega de 
      <strong>
        {{ $responsiva->productos->pluck('nombre')->join(', ') }}
      </strong>.
    </p>

    <br><br><br><br>

    <p>
        @if ($responsiva->colaborador->empresa_id == 1)
            Recibí de : TIP TOP INDUSTRIAL S.A DE C.V el siguiente equipo para uso exclusivo del desempeño 
            de mis actividades laborales asignadas, el cual se reserva el derecho de retirar cuando así lo 
            considere necesario la empresa.
        @elseif ($responsiva->colaborador->empresa_id == 2)
            Recibí de : Vulcanización y Servicios Industriales, S.A de C.V el siguiente equipo para uso 
            exclusivo del desempeño de mis actividades laborales asignadas, el cual se reserva el derecho 
            de retirar cuando así lo considere necesario la empresa.
        @endif
    </p>

    <br>

    <p>Consta de las siguientes características:</p>
<table>
    <thead>
        <tr class="text-center">
            <th>EQUIPO</th>
            <th>DESCRIPCIÓN</th>
            <th>MARCA</th>
            <th>MODELO</th>
            <th>NO. SERIE</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($responsiva->productos as $producto)
            <tr class="text-center">
                <td>{{ $producto->nombre }}</td>
                <td class="descripcion">{{ $producto->descripcion }}</td>
                <td>{{ $producto->marca }}</td>
                <td>{{ $producto->modelo }}</td>
                <td>{{ $producto->no_serie }}</td>
            </tr>
        @endforeach
        @for ($i = 0; $i < 5 - $responsiva->productos->count(); $i++)
            <tr style="height: 40px;" class="text-center">
                <td>&nbsp;</td><td></td><td></td><td></td><td></td>
            </tr>
        @endfor
    </tbody>
</table>

    <br>

    <p>
        Los daños ocasionados por el mal manejo o imprudencia, así como el robo o pérdida 
        total o parcial a causa de negligencia o descuido, serán mi responsabilidad y asumo 
        las consecuencias que de esto deriven.
    </p>

    <br>

    <table style="width: 40%; float: right;">
        <tr>
            <td style="width: 50%;"><strong>FECHA DE ENTREGA:</strong></td>
            <td style="width: 50%;">{{ $responsiva->fecha_entrega }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <br><br><br><br>

    <table style="width: 100%; border-collapse: collapse; margin-top: 80px; font-size: 10px;">
      <tr>
        <!-- ENTREGÓ (izquierda) -->
        <td style="width: 30%; text-align: center; border: none;">
          <p><strong>ENTREGÓ</strong></p>
          @php
              $firmaEntrego = public_path('storage/firmas/' . ($responsiva->entrego?->name ?? '') . '.jpg');
          @endphp
          @if(file_exists($firmaEntrego))
              <img src="{{ $firmaEntrego }}" style="max-height: 50px;"><br>
          @else
              <div style="height: 50px;"></div>
          @endif
          <p style="margin: 0;">{{ $responsiva->entrego->name ?? '' }}</p>
          <hr style="margin: 0 auto; width: 80%; border: none; border-top: 1px solid #444;">
        </td>
    
        <!-- ESPACIO EN MEDIO -->
        <td style="width: 40%; border: none;"></td>
    
        <!-- RECIBIÓ (derecha) -->
        <td style="width: 30%; text-align: center; border: none;">
          <p><strong>RECIBIÓ</strong></p>
          @php
              $firmaRecibio = public_path('storage/' . $responsiva->firma_recibio);
          @endphp
          @if(file_exists($firmaRecibio))
              <img src="{{ $firmaRecibio }}" style="max-height: 50px;"><br>
          @else
              <div style="height: 50px;"></div>
          @endif
          <p style="margin: 0;">{{ $responsiva->recibio?->nombre }} {{ $responsiva->recibio?->apellido }}</p>
          <hr style="margin: 0 auto; width: 80%; border: none; border-top: 1px solid #444;">
        </td>
      </tr>
    
      <!-- AUTORIZÓ CENTRADO DEBAJO -->
      <tr>
        <td colspan="3" style="padding-top: 40px; text-align: center; border: none;">
          <p><strong>AUTORIZÓ</strong></p>
          @php
              $firmaAutorizo = public_path('storage/firmas/' . ($responsiva->autorizo?->name ?? '') . '.jpg');
          @endphp
          @if(file_exists($firmaAutorizo))
              <img src="{{ $firmaAutorizo }}" style="max-height: 50px;"><br>
          @else
              <div style="height: 50px;"></div>
          @endif
          <p style="margin: 0;">{{ $responsiva->autorizo->name ?? '' }}</p>
          <hr style="margin: 0 auto; width: 30%; border: none; border-top: 1px solid #444;">
        </td>
      </tr>
    </table>
    
    

  </div>

</body>
</html>