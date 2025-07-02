@extends('layouts.main')

@section('titulo', 'Transporte - Responsiva No. ' . $responsiva->id)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle"><h1>Responsiva de Transporte</h1></div>

  <section class="section">
    <div class="container bg-white p-4" style="font-family: Arial, sans-serif; border:1px solid #ccc;">

      {{-- Encabezado --}}
      <table style="width: 100%; table-layout: fixed; border-collapse: collapse; border: 1px solid #ccc;">
        <tr>
          <td rowspan="3" style="width: 40%; text-align: center; vertical-align: middle; border-right: 1px solid #ccc;">
            <img src="{{ asset('NiceAdmin/assets/img/GrupoVysisaLogo.png') }}" alt="Logo Vysisa" style="width: 45%; max-height: 120px;">
          </td>
          <td style="width: 80%; text-align: center; font-size: 18px; font-weight: bold; border-bottom: 1px solid #ccc;">
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
            FORMATO DE TRANSPORTE
          </td>
        </tr>
      </table>

      <br>

      <!-- Primera tabla (con borde inferior conservado) -->
      <table style="width: 100%; table-layout: fixed; border-collapse: collapse;">
        <tr>
            {{-- NO. DE SALIDA --}}
            <td style="border: 1px solid #ccc; padding: 0; width: 25%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 45%; border-right: 1px solid #ccc; padding: 4px; white-space: nowrap;"><strong>No. DE SALIDA:</strong></td>
                        <td class="text-center" style="width: 55%; padding: 4px; white-space: nowrap;">OES-{{ str_pad($responsiva->id, 5, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                </table>
            </td>

            {{-- FECHA DE SOLICITUD --}}
            <td style="border: 1px solid #ccc; padding: 0; width: 25%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 45%; border-right: 1px solid #ccc; padding: 4px; white-space: nowrap;"><strong>FECHA DE SOLICITUD:</strong></td>
                        <td class="text-center" style="width: 55%; padding: 4px; white-space: nowrap;">{{ $responsiva->fecha_asignacion }}</td>
                    </tr>
                </table>
            </td>

            {{-- NOMBRE DEL USUARIO --}}
            <td style="border: 1px solid #ccc; padding: 0; width: 50%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 25%; border-right: 1px solid #ccc; padding: 4px; white-space: nowrap;"><strong>NOMBRE DEL USUARIO:</strong></td>
                        <td class="text-center" style="width: 75%; padding: 4px; white-space: nowrap;">
                            {{ $responsiva->colaborador->nombre ?? '-' }} {{ $responsiva->colaborador->apellido ?? '' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Segunda tabla (sin borde superior) -->
    <table style="width: 100%; table-layout: fixed; border-collapse: collapse; border-top: none; margin-top: -1px;">
        <tr>
            {{-- ÁREA/DEPTO/SEDE --}}
            <td colspan="2" style="border: 1px solid #ccc; border-top: none; padding: 0; width: 40%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 30%; border-right: 1px solid #ccc; padding: 8px;"><strong>ÁREA/DEPTO/SEDE:</strong></td>
                        <td class="text-center" style="width: 70%; padding: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $responsiva->colaborador->unidadServicio->nombre ?? '-' }} -
                            {{ $responsiva->colaborador->areaDepartamento->nombre ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>

            {{-- MOTIVO DE ENTREGA --}}
            <td style="border: 1px solid #ccc; border-top: none; padding: 0; width: 50%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 30%; border-right: 1px solid #ccc; padding: 8px;"><strong>MOTIVO DE ENTREGA:</strong></td>
                        <td style="padding: 8px; white-space: nowrap; text-align: center;">
                            @foreach (['Fallo', 'Prestamo Provisional', 'Asignacion'] as $motivo)
                                <span style="margin: 0 10px;">
                                    {{ strtoupper($motivo) }}
                                    <input type="checkbox" disabled {{ $responsiva->motivo_entrega === $motivo ? 'checked' : '' }}>
                                </span>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

      {{-- Descripción --}}
      <br><br><br><br>
      <p>
        Por medio de la presente hago constar que: Se hace entrega de 
        <strong>{{ $responsiva->productos->pluck('nombre')->join(', ') }}</strong>.
      </p>

      <br><br><br><br>

      <p>
        @if ($responsiva->colaborador->empresa_id == 1)
          Recibí de : TIP TOP INDUSTRIAL S.A DE C.V el siguiente equipo para traslado temporal bajo mi responsabilidad.
        @elseif ($responsiva->colaborador->empresa_id == 2)
          Recibí de : Vulcanización y Servicios Industriales, S.A de C.V el siguiente equipo para traslado temporal bajo mi responsabilidad.
        @endif
      </p>

      {{-- Productos --}}
      <br>
      <p>Consta de las siguientes características:</p>
      <table class="table table-bordered mt-4">
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
              <td>{{ $producto->descripcion }}</td>
              <td>{{ $producto->marca }}</td>
              <td>{{ $producto->modelo }}</td>
              <td>{{ $producto->no_serie }}</td>
            </tr>
          @endforeach
          @for ($i = 0; $i < max(0, 5 - $responsiva->productos->count()); $i++)
            <tr style="height: 40px;" class="text-center">
              <td>&nbsp;</td><td></td><td></td><td></td><td></td>
            </tr>
          @endfor
        </tbody>
      </table>

      {{-- Aviso --}}
      <br>
      <p>
        Este documento respalda el traslado temporal del equipo mencionado. El colaborador designado como transportista es responsable del cuidado del mismo durante el trayecto hasta su entrega al destinatario correspondiente.
      </p>

      {{-- Fecha --}}
      <br>
      <table style="width: 40%; float: right; border-collapse: collapse; margin-top: 10px;" border="1">
        <tr>
          <td style="width: 50%; border: 1px solid #ccc; padding: 8px;"><strong>FECHA DE ENTREGA:</strong></td>
          <td style="width: 50%; border: 1px solid #ccc; padding: 8px;">{{ $responsiva->fecha_entrega }}</td>
        </tr>
      </table>
      <div style="clear: both;"></div>

      {{-- Firmas --}}
      <br><br><br><br>
      <div class="text-center mt-5">
        <div class="d-flex justify-content-between">
          <!-- ENTREGÓ -->
          <div style="width: 30%;">
            <p><strong>ENTREGÓ</strong></p>
            <div>
              @php
                $firmaEntrego = public_path('storage/firmas/' . ($responsiva->entrego?->name ?? '') . '.jpg');
              @endphp
              @if(file_exists($firmaEntrego))
                <img src="{{ asset('storage/firmas/' . $responsiva->entrego->name . '.jpg') }}" style="max-height: 50px;">
              @else
                <div style="height: 50px;"></div>
              @endif
              <p style="margin: 0;">{{ $responsiva->entrego->name ?? '' }}</p>
              <hr style="margin: 0;">
            </div>
          </div>

          <!-- RECIBIÓ -->
<div style="width: 30%;">
  <p><strong>RECIBIÓ</strong></p>
  @if ($responsiva->firma_transportista)
    <div style="position: relative; display: inline-block;">
      <img src="{{ asset('storage/' . $responsiva->firma_transportista) }}" style="max-height: 50px;">
      <button type="button" class="btn btn-sm btn-outline-danger" 
              onclick="abrirModalFirmaTransportista()"
              style="position: absolute; top: -10px; right: -20px; padding: 2px 6px; font-size: 12px; line-height: 1;">
        ❌
      </button>
    </div>
  @else
    <button class="btn btn-outline-success btn-sm" onclick="abrirModalFirmaTransportista()">✍ Iniciar Firma</button>
  @endif
  <p style="margin: 0;">{{ $transportista }}</p>
  <hr style="margin: 0;">
</div>
        </div>

        <!-- AUTORIZÓ -->
        <br><br><br><br>
        <div style="width: 40%; margin: 0 auto;">
          <p><strong>AUTORIZÓ</strong></p>
          @php
            $firmaAutorizo = public_path('storage/firmas/' . ($responsiva->autorizo?->name ?? '') . '.jpg');
          @endphp
          @if(file_exists($firmaAutorizo))
            <img src="{{ asset('storage/firmas/' . $responsiva->autorizo->name . '.jpg') }}" style="max-height: 50px;">
          @else
            <div style="height: 50px;"></div>
          @endif
          <p style="margin: 0;">{{ $responsiva->autorizo->name ?? '' }}</p>
          <hr style="margin: 0; width: 40%; margin-left: auto; margin-right: auto;">
        </div>
      </div>

      {{-- Botones --}}
      <div class="d-flex justify-content-between">
        {{-- Botón Volver --}}
        <div>
          <a href="{{ request()->query('from') === 'consulta' ? route('consulta-responsiva') : route('responsivas.ver', ['id' => $responsiva->id]) }}" 
             class="btn btn-outline-primary">
            Volver
          </a>
        </div>
      
        {{-- Botones de acción --}}
        <div>
          <a href="{{ route('responsivas.transporte.edit', ['id' => $responsiva->id, 'from' => request()->query('from')]) }}" class="btn btn-primary">
            Editar
          </a>
      
          <form action="{{ route('responsivas.transporte.store', $responsiva->id) }}" method="POST" target="_blank" class="d-inline">
            @csrf
            <input type="hidden" name="nombre_transportista" value="{{ $transportista }}">
            <button type="submit" class="btn btn-secondary">Descargar PDF</button>
        </form>
        </div>
      </div>

    </div>
  </section>
</main>

<!-- MODAL DE FIRMA TRANSPORTISTA -->
<div id="modalFirmaTransportista" style="
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;">
  <div style="background: white; padding: 20px; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
    <h5 class="text-center mb-3">Firma del Transportista</h5>
    <form method="POST" action="{{ route('responsivas.transporte.firmar', $responsiva->id) }}">
      @csrf
      @method('PUT')
      <div class="text-center">
        <canvas id="signatureCanvasTransportista" width="500" height="150" style="border: 1px solid #ccc;"></canvas>
      </div>
      <input type="hidden" name="firma_transportista" id="firma_transportista">

      <div class="mt-3 d-flex justify-content-center gap-2">
        <button type="button" onclick="clearSignatureTransportista()" class="btn btn-secondary">Borrar</button>
        <button type="submit" class="btn btn-success">Guardar Firma</button>
        <button type="button" onclick="cerrarModalFirmaTransportista()" class="btn btn-danger">Cancelar</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
  let signaturePadTransportista;

  function abrirModalFirmaTransportista() {
    document.getElementById('modalFirmaTransportista').style.display = 'flex';
    setTimeout(() => {
      const canvas = document.getElementById("signatureCanvasTransportista");
      signaturePadTransportista = new SignaturePad(canvas);
    }, 200);
  }

  function cerrarModalFirmaTransportista() {
    document.getElementById('modalFirmaTransportista').style.display = 'none';
  }

  function clearSignatureTransportista() {
    if (signaturePadTransportista) {
      signaturePadTransportista.clear();
      document.getElementById('firma_transportista').value = '';
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#modalFirmaTransportista form');
    form.addEventListener("submit", function () {
      if (!signaturePadTransportista.isEmpty()) {
        document.getElementById('firma_transportista').value = signaturePadTransportista.toDataURL("image/png");
      }
    });
  });
</script>
@endpush

@endsection
