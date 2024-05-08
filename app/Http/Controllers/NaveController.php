<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nave;
use Illuminate\Support\Facades\DB;
use Exception;

class NaveController extends Controller
{
    //
    public function getall($id = null ){

        if(isset($id) && $id == 1){
            try{
                $resp = Nave::select('id','nombre','flota_id')
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
                //ARREGLAR SEGUN FLOTA ID
                $resp = Nave::select('naves.id','naves.nombre','flotas.nombre as flota', 
                                        'naves.enabled','naves.updated_at')
                            ->join('flotas','flotas.id','=','naves.flota_id')
                                        ->get();
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
            //ARREGLAR SEGUN FLOTA ID
            $resp = Nave::select('id','nombre', 
                                    'flota_id','enabled')
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
            //ARREGLAR SEGUN FLOTA ID
            DB::beginTransaction();
            $resp = new Nave();
            $resp->nombre = strtoupper($request->nombre);
            $resp->flota_id = $request->flota_id;
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
            //ARREGLAR SEGUN FLOTA ID
            $respEdit = Nave::find($request->id);
            if (!$respEdit) {
                throw new Exception('Nave no encontrada');
            }
            DB::beginTransaction();
            $respEdit->nombre = strtoupper($request->nombre);
            $respEdit->flota_id = $request->flota_id;
            $respEdit->enabled = $request->enabled;
            $respEdit->save();
            DB::commit();
            $respEdit->load('flota');
            $respEdit->flota = $respEdit->flota->nombre;
            //Log::info('Nave actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled', 'flota', 'updated_at']);

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
