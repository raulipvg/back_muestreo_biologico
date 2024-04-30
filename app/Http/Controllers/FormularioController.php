<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EspecieController;

class FormularioController extends Controller
{
    public function getall(){
        try{
            $resp = Formulario::select('id','titulo', 
                                        'descripcion','enabled','created_at')->get();
            return response()->json($resp, 201);
            
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function get($id){
        try{
            $resp = Formulario::select('id','titulo', 
                                        'descripcion','enabled')
                                        ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Formulario no encontrado');
            }
            //Log::info('Ver información de atributo');
            return response()->json($resp, 201);
        }catch(Exception $e){
           // Log::error('Error al ver atributo',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
    public function update(Request $request){

        try{
            $respEdit = Formulario::find($request->id);

            if (!$respEdit) {
                throw new Exception('Formulario no encontrado');
            }
            DB::beginTransaction();

            $respEdit->fill([
                'titulo' => strtoupper($request->titulo),
                'descripcion' => strtoupper($request->descripcion),
                'enabled' => $request->enabled
            ]);
            $respEdit->save();
            
            DB::commit();
            $respEdit = $respEdit->only(['id','titulo','descripcion','enabled']);
           // Log::info('Edición de atributo');
             return response()->json($respEdit,201);

        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al editar atributo',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Formulario::find($request->id);

            if (!$respEdit) {
                throw new Exception('Formulario no encontrado');
            }
            DB::beginTransaction();
            Formulario::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled') // Invierte el valor de 'enabled'
            ]);
            $respEdit->save();
            DB::commit();
           // Log::info('Cambio de estado en área');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
            
        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al cambiar estado del área',[$e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function getselects(){

        $especiesController = new EspecieController();
        $especies = $especiesController->getall(1);

        $navesController = new NaveController();
        $naves = $navesController->getall(1);

        $plantasController = new PlantaController();
        $plantas = $plantasController->getall(1);

        $lugarMController = new LugarMController();
        $lugares = $lugarMController->getall(1);

        $clasiController = new ClasificacionController();
        $clasificaciones = $clasiController->getall(1);

        $flotaController = new FlotaController();
        $flotas = $flotaController->getall(1);

        $puertoController = new PuertoController();
        $puertos = $puertoController->getall(1);

        $departamentoController = new DepartamentoController();
        $departamentos = $departamentoController->getall(1);

        $personaController = new PersonaController();
        $personas = $personaController->getall(1);

        return response()->json([
            'especies' => $especies,
            'naves' => $naves,
            'plantas' => $plantas,
            'lugarms' => $lugares,
            'clasificaciones' => $clasificaciones,
            'flotas' => $flotas,
            'puertos' => $puertos,
            'departamentos' => $departamentos,
            'personas' => $personas
        ],201);
    }

}
