<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nave;
use Illuminate\Support\Facades\DB;
use Exception;

class NaveController extends Controller
{
    //
    public function getall(){

        try{
            $resp = Nave::select('id','nombre', 
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
            $resp = Nave::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Nave no encontrada');
            }
            //Log::info('Ver información de nave');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver la nave',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Nave();
            $resp->nombre = strtoupper($request->nombre);
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);
            //Log::info('Nave creada');
            return response()->json($resp, 201);
        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al crear nave',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function update(Request $request){

        try{
            $respEdit = Nave::find($request->id);
            if (!$respEdit) {
                throw new Exception('Nave no encontrada');
            }
            DB::beginTransaction();
            $respEdit->nombre = strtoupper($request->nombre);
            $respEdit->enabled = $request->enabled;
            $respEdit->save();
            DB::commit();
            //Log::info('Nave actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled', 'updated_at']);
            return response()->json($respEdit, 201);
        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al actualizar nave',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Nave::find($request->id);
            if (!$respEdit) {
                throw new Exception('Nave no encontrada');
            }
            DB::beginTransaction();
            Nave::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();
            //Log::info('Estado de nave cambiado');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al cambiar estado de nave',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
