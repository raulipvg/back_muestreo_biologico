<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class PersonaController extends Controller
{
    //
    public function getall($id = null){

        if(isset($id) && $id == 1){
            try{
                $resp = Persona::select('id', 
                                    DB::raw("CONCAT(nombre, ' ', apellido) AS nombre"))
                                    ->where('enabled',true)
                                    ->orderBy('nombre','asc')
                                    ->get();
                return $resp;                
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ],500);
            }
        }else{
            try{
                $resp = Persona::select('id','nombre', 
                                        'enabled','updated_at')->get();
                return response()->json($resp, 201);
                
            }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ],500);
            }
        }

    }

    public function get($id){
        try{
            $resp = Persona::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Persona no encontrada');
            }
            //Log::info('Ver información de persona');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver persona',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Persona();
            $resp->nombre = strtoupper($request->nombre);
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);
            //log::info('Nueva persona creada');
            return response()->json($resp, 201);
        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al crear persona',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function update(Request $request){

        try{
            $respEdit = Persona::find($request->id);

            if (!$respEdit) {
                throw new Exception('Persona no encontrada');
            }
            DB::beginTransaction();

            $respEdit->fill([
                'nombre' => strtoupper($request->nombre),
                'enabled' => $request->enabled
            ]);
            $respEdit->save();
            DB::commit();
            //Log::info('Persona actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled', 'updated_at']);
            return response()->json($respEdit, 201);

        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al actualizar persona',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Persona::find($request->id);

            if (!$respEdit) {
                throw new Exception('Persona no encontrada');
            }

            DB::beginTransaction();
            Persona::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();

            //Log::info('Estado de persona cambiado');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al cambiar estado de persona',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
