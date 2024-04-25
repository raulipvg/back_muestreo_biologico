<?php

namespace App\Http\Controllers;

use App\Models\Flota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FlotaController extends Controller
{
    //
    public function getall(){

        try{
            $resp = Flota::select('id','nombre', 
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
            $resp = Flota::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Flota no encontrada');
            }
            //Log::info('Ver información de flota');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver flota',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Flota();
            $resp->nombre = strtoupper($request->nombre);
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);
            //log::info('Nueva flota creada');
            return response()->json($resp, 201);
        }catch(Exception $e){
            DB::rollBack();
            // Log::error('Error al crear flota',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function update(Request $request){
        try{
            $respEdit = Flota::find($request->id);

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
            //log::info('Flota actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled', 'updated_at']);      
            return response()->json($respEdit, 201);
        }catch(Exception $e){
            DB::rollBack();
            // Log::error('Error al actualizar flota',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Flota::find($request->id);

            if (!$respEdit) {
                throw new Exception('Flota no encontrada');
            }

            DB::beginTransaction();
            Flota::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();

            //Log::info('Estado de flota cambiado');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al cambiar estado de flota',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
