<?php

namespace App\Http\Controllers;

use App\Models\AreaDepartamento;
use App\Models\Colaborador;
use App\Models\Empresa;
use App\Models\UnidadServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Colaboradores extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colaboradores = Colaborador::with(['empresa', 'unidadServicio', 'areaDepartamento'])->get();
        return view('modules.colaboradores.index', compact('colaboradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$areas = AreaDepartamento::with('unidad.empresa')->get(); // trae también unidad y empresa relacionadas
        //return view('modules.colaboradores.create', compact('areas'));

        $empresas = Empresa::orderBy('nombre')->get();

        $relaciones = [];

        $puestos = $this->obtenerListaDePuestos(); // <- Aquí defines los puestos

        $areas = AreaDepartamento::with('unidad.empresa')->get();

        foreach ($areas as $area) {
            $empresaId = $area->unidad->empresa->id;
            $unidadId = $area->unidad->id;

            // Agregar empresa si no existe
            if (!isset($relaciones[$empresaId])) {
                $relaciones[$empresaId] = [
                    'unidades' => [],
                    'areas' => []
                ];
            }

            // Agregar unidad única por empresa
            if (!collect($relaciones[$empresaId]['unidades'])->contains('id', $unidadId)) {
                $relaciones[$empresaId]['unidades'][] = [
                    'id' => $unidadId,
                    'nombre' => $area->unidad->nombre
                ];
            }

            // Agregar área relacionada con esa unidad
            $relaciones[$empresaId]['areas'][] = [
                'id' => $area->id,
                'nombre' => $area->nombre,
                'unidad_id' => $unidadId
            ];
        }

        return view('modules.colaboradores.create', compact('empresas', 'relaciones', 'puestos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'empresa_id' => 'required|integer|exists:empresas,id',
            'unidad_servicio_id' => 'required|integer|exists:unidad_servicios,id',
            'area_departamento_id' => 'required|integer|exists:area_departamentos,id',
            'puesto' => 'required|string',
        ]);

        Colaborador::create([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'empresa_id' => $request->empresa_id,
            'unidad_servicio_id' => $request->unidad_servicio_id,
            'area_departamento_id' => $request->area_departamento_id,
            'puesto' => $request->puesto,
        ]);

        return redirect()->route('colaboradores')->with([
            'success' => 'Colaborador creado correctamente.',
            'show_created_modal' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $colaborador = Colaborador::with(['empresa', 'unidadServicio', 'areaDepartamento'])->findOrFail($id);
        return view('modules.colaboradores.show', compact('colaborador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $empresas = Empresa::orderBy('nombre')->get();

        $relaciones = [];
        $puestos = $this->obtenerListaDePuestos();

        $areas = AreaDepartamento::with('unidad.empresa')->get();
        foreach ($areas as $area) {
            $empresaId = $area->unidad->empresa->id;
            $unidadId = $area->unidad->id;

            if (!isset($relaciones[$empresaId])) {
                $relaciones[$empresaId] = [
                    'unidades' => [],
                    'areas' => []
                ];
            }

            if (!collect($relaciones[$empresaId]['unidades'])->contains('id', $unidadId)) {
                $relaciones[$empresaId]['unidades'][] = [
                    'id' => $unidadId,
                    'nombre' => $area->unidad->nombre
                ];
            }

            $relaciones[$empresaId]['areas'][] = [
                'id' => $area->id,
                'nombre' => $area->nombre,
                'unidad_id' => $unidadId
            ];
        }

        return view('modules.colaboradores.edit', compact('colaborador', 'empresas', 'relaciones', 'puestos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'empresa_id' => 'required|integer|exists:empresas,id',
            'unidad_servicio_id' => 'required|integer|exists:unidad_servicios,id',
            'area_departamento_id' => 'required|integer|exists:area_departamentos,id',
            'puesto' => 'required|string|max:255',
        ]);

        $colaborador = Colaborador::findOrFail($id);

        $colaborador->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'empresa_id' => $request->empresa_id,
            'unidad_servicio_id' => $request->unidad_servicio_id,
            'area_departamento_id' => $request->area_departamento_id,
            'puesto' => $request->puesto,
        ]);

        return redirect()->route('colaboradores')->with('success', 'Colaborador actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $colaborador = Colaborador::findOrFail($id);
            $colaborador->delete();

            return redirect()->route('colaboradores')->with([
                'show_success_modal' => true,
                'success' => 'Colaborador eliminado correctamente.'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Error al eliminar colaborador:', [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);

            return redirect()->route('colaboradores')->with('show_error_modal', true);
        }
    }

    public function getUnidades($empresaId)
    {
        $unidades = UnidadServicio::where('empresa_id', $empresaId)->get();
        return response()->json($unidades);
    }

    public function getAreas($unidadId)
    {
        $areas = AreaDepartamento::where('unidad_servicio_id', $unidadId)->get();
        return response()->json($areas);
    }

    private function obtenerListaDePuestos()
    {
        return [
            "Analista de Compras",
            "Analista de Contabilidad",
            "Analista de Nominas",
            "Asesor Tecnico",
            "Asistente de Desarrollo de Capital Humano",
            "Asistente de Direccion",
            "Asistente de Marketing",
            "Asistente de Operaciones",
            "Asistente de SGI",
            "Asistente de Tesoreria",
            "Auxiliar Admon de Ingenieria",
            "Auxiliar Vulcanizador 1",
            "Auxiliar Vulcanizador 2",
            "Auxiliar Vulcanizador 3",
            "Auxiliar Administrativo",
            "Auxiliar Comercial",
            "Auxiliar de Almacen",
            "Auxiliar de Cobranza",
            "Auxiliar de Contabilidad",
            "Auxiliar de Embarques",
            "Auxiliar de Facturacion",
            "Auxiliar de Seguridad",
            "Ayudante Comercial",
            "Ayudante de Intendencia",
            "Ayudante General",
            "Chofer",
            "Coordinador Comercial",
            "Coordinador de Almacen",
            "Coordinador de Calidad",
            "Coordinador de Ingenieria",
            "Coordinador de Seguridad",
            "Coordinador de Servicios Generales",
            "Coordinador de Sistemas",
            "Coordinador de Taller",
            "Director Comercial",
            "Director de Finanzas",
            "Director General",
            "Director Operativo",
            "Directora de Admon y Finanzas",
            "Ejecutivo de Atencion a Clientes",
            "Gerente de Abastos",
            "Gerente de Contabilidad",
            "Gerente de Filial",
            "Gerente de Ventas",
            "Ingeniero de Campo",
            "Ingeniero de Sistemas",
            "Instrumentista",
            "Lider de Capital Humano",
            "Lider de Zona",
            "Mantenimiento",
            "Practicante",
            "Practicante de Contabilidad",
            "Practicante de Ingenieria",
            "Promotor de Linea",
            "Promotor de Marca",
            "Responsable de Abastos",
            "Responsable de Ingenieria",
            "Responsable de Marketing",
            "Responsable de Mejora Continua",
            "Responsable de Proteccion de Superficies",
            "Responsable de Sistemas",
            "Responsable de Taller",
            "Responsable de Tesoreria",
            "Responsable de SGI",
            "Secretaria",
            "Supervisor 1",
            "Supervisor 2",
            "Supervisor 3",
            "Supervisor de Produccion de Pasamanos",
            "Supervisor de Seguridad",
            "Vulcanizador 1",
            "Vulcanizador 2",
            "Vulcanizador 3"
        ];
    }
}
