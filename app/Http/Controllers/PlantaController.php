<?php

namespace App\Http\Controllers;

use App\Models\Planta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PlantaController extends Controller
{
    //
    public function getall(){

        try{
            $resp = Planta::select('id','nombre', 
                                    'enabled','updated_at')->get();
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
            $resp = Planta::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Planta no encontrada');
            }
            //Log::info('Ver información de planta');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver planta',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Planta();
            $resp->nombre = strtoupper($request->nombre);
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();
            //Log::info('Nueva planta creada');
            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);

            return response()->json($resp, 201);
        }catch(Exception $e){
            DB::rollBack();
             // Log::error('Error al crear planta',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function update(Request $request){

        try{
            $respEdit = Planta::find($request->id);

            if (!$respEdit) {
                throw new Exception('Planta no encontrada');
            }
            DB::beginTransaction();

            $respEdit->fill([
                'nombre' => strtoupper($request->nombre),
                'enabled' => $request->enabled
            ]);
            $respEdit->save();
            DB::commit();
            //Log::info('Planta actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled', 'updated_at']);
            return response()->json($respEdit, 201);

        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al actualizar la planta',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Planta::find($request->id);

            if (!$respEdit) {
                throw new Exception('Planta no encontrada');
            }

            DB::beginTransaction();
            Planta::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();

            //Log::info('Estado de planta cambiado');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al cambiar estado de planta',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
