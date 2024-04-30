<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ClasificacionController extends Controller
{
    //
    public function getall($id = null){

        if(isset($id) && $id == 1){
            try{
                $resp = Clasificacion::select('id','nombre')
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
                $resp = Clasificacion::select('id','nombre', 
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
            $resp = Clasificacion::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Clasificacion no encontrada');
            }
            //Log::info('Ver información de clasificacion');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver clasificacion',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Clasificacion();
            $resp->nombre = $request->nombre? strtoupper($request->nombre): null;
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);
            //log::info('Nueva clasificacion creada');
            return response()->json($resp, 201);
        }catch(Exception $e){
            DB::rollBack();
            // Log::error('Error al crear clasificacion',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function update(Request $request){

        try{
            $respEdit = Clasificacion::find($request->id);

            if (!$respEdit) {
                throw new Exception('Clasificacion no encontrada');
            }
            DB::beginTransaction();

            $respEdit->fill([
                'nombre' => strtoupper($request->nombre),
                'enabled' => $request->enabled
            ]);
            $respEdit->save();
            DB::commit();
            //Log::info('Clasificacion actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled', 'updated_at']);
            return response()->json($respEdit, 201);

        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al actualizar la clasificacion',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Clasificacion::find($request->id);

            if (!$respEdit) {
                throw new Exception('Clasificacion no encontrada');
            }

            DB::beginTransaction();
            Clasificacion::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();

            //Log::info('Estado de la clasificacion cambiada');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);

        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al actualizar la clasificacion',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

}
