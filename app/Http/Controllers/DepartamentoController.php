<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class DepartamentoController extends Controller
{
    //

    public function getall(){

        try{
            $resp = Departamento::select('id','nombre', 
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
            $resp = Departamento::select('id','nombre', 
                                    'enabled')
                                    ->where('id',$id)->first();
            if (!$resp) {
                throw new Exception('Departamento no encontrado');
            }
            //Log::info('Ver información de departamento');
            return response()->json($resp, 201);
        }catch(Exception $e){
              // Log::error('Error al ver departamento',[$e]);
                return response()->json([
                 'success' => false,
                 'message' => $e->getMessage()
                ],500);
          }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();
            $resp = new Departamento();
            $resp->nombre = strtoupper($request->nombre);
            $resp->enabled = $request->enabled;
            $resp->save();
            DB::commit();

            $resp = $resp->only(['id','nombre','enabled', 'updated_at']);
            //log::info('Nuevo departamento creado');
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
            $respEdit = Departamento::find($request->id);

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
            //log::info('Departamento actualizado');
            return response()->json($respEdit, 201);
        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al actualizar departamento',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function cambiarestado(Request $request){
        try{
            $respEdit = Departamento::find($request->id);

            if (!$respEdit) {
                throw new Exception('Especie no encontrada');
            }

            DB::beginTransaction();
            Departamento::where('id', $request->id)->update([
                'enabled' => DB::raw('NOT enabled')
            ]);
            $respEdit->save();
            DB::commit();
            
            //log::info('Estado de departamento cambiado');
            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente'
            ],201);
        }catch(Exception $e){
            DB::rollBack();
            //log::error('Error al cambiar estado de departamento',[$e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
