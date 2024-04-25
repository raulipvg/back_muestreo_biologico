<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class EspecieController extends Controller
{
    //
    public function getall(){

        try{
            $resp = Especie::select('id','nombre', 
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
            $resp = Especie::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Especie no encontrada');
            }
            //Log::info('Ver información de especie');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver especie',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }
    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Especie();
            $resp->nombre = strtoupper($request->nombre);
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);
            //log::info('Nueva especie creada');
            return response()->json($resp, 201);
        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al crear especie',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function update(Request $request){

        try{
            $respEdit = Especie::find($request->id);

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
            //Log::info('Especie actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled', 'updated_at']);
            return response()->json($respEdit, 201);

        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al actualizar especie',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
    public function cambiarestado(Request $request){
        try{
            $respEdit = Especie::find($request->id);

            if (!$respEdit) {
                throw new Exception('Especie no encontrada');
            }

            DB::beginTransaction();
            Especie::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();

            //Log::info('Estado de especie cambiado');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            //Log::error('Error al cambiar estado de especie',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
