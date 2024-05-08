<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class EspecieController extends Controller
{
    //
    public function getall($id = null){

        if(isset($id) && $id == 1){
            try{
                $resp = Especie::select('id','nombre',
                                        'talla_min','talla_max',
                                        'peso_min','peso_max','tipo1')
                                    ->where('enabled',true)
                                    ->orderBy('nombre','asc')
                                    ->get();
                return $resp;                
            }catch(Exception $e){
                return false;
            }
        }else{
            try{
                $resp = Especie::select('id','nombre', 'tipo1',
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
            $resp = Especie::select('id','nombre',
                                    'talla_min','talla_max',
                                    'peso_min','peso_max',
                                    'talla_menor_a','enabled','tipo1')
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
            $resp->talla_max = $request->talla_max;
            $resp->talla_min = $request->talla_min;
            $resp->peso_max = $request->peso_max;
            $resp->peso_min = $request->peso_min;
            $resp->talla_menor_a = $request->talla_menor_a;
            $resp->enabled = $request->enabled;
            $resp->tipo1 = $request->tipo1;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled','tipo1', 'updated_at']);
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
                'talla_max' => $request->talla_max,
                'talla_min' => $request->talla_min,
                'peso_max' => $request->peso_max,
                'peso_min' => $request->peso_min,
                'talla_menor_a' => $request->talla_menor_a,
                'tipo1' => $request->tipo1,
                'enabled' => $request->enabled
            ]);
            $respEdit->save();
            DB::commit();
            //Log::info('Especie actualizada');
            $respEdit = $respEdit->only(['id','nombre','enabled','tipo1', 'updated_at']);
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
