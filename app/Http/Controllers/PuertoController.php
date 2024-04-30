<?php

namespace App\Http\Controllers;

use App\Models\Puerto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PuertoController extends Controller
{
    //
    public function getall($id = null){

        if(isset($id) && $id == 1){
            try{
                $resp = Puerto::select('id','nombre')
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
                $resp = Puerto::select('id','nombre', 
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
            $resp = Puerto::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Puerto no encontrado');
            }
            //Log::info('Ver información de puerto');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver puerto',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Puerto();
            $resp->nombre = strtoupper($request->nombre);
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);
            //log::info('Nuevo puerto creado');
            return response()->json($resp, 201);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function update(Request $request){
        try{
            $respEdit = Puerto::find($request->id);

            if (!$respEdit) {
                throw new Exception('Especie no encontrada');
            }
            DB::beginTransaction();

            $respEdit->fill([
                'nombre' => strtoupper($request->nombre),
                'enabled' => $request->enabled
            ]);
            $respEdit->save();
            DB::commit();
            $respEdit = $respEdit->only(['id','nombre','enabled', 'updated_at']);
            //log::info('Puerto actualizado');
            return response()->json($respEdit, 201);

        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al actualizar puerto',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Puerto::find($request->id);

            if (!$respEdit) {
                throw new Exception('Puerto no encontrado');
            }

            DB::beginTransaction();
            Puerto::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();
            
            //log::info('Estado de puerto cambiado');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al cambiar estado de puerto',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
