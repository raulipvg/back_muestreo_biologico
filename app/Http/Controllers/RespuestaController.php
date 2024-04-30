<?php

namespace App\Http\Controllers;

use App\Models\RespFormulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use MathPHP\Statistics\Average;
use MathPHP\Statistics\Mode;



class RespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {
        $resp= RespFormulario::select('resp_formularios.Id','formularios.Titulo',
                                        'resp_formularios.Enabled','resp_formularios.created_at')
                                    ->join('formularios','formularios.Id','=','resp_formularios.FormularioId')
                                    ->get();

        return response()->json($resp ,201);
    }

    public function Create(Request $request){
        
        try{
        $data = $request->all();

        $resp = new RespFormulario();
        $resp->formulario_id = $data['formulario_id'];
        $resp->enabled = true;
        $resp->usuario_id = 1; //arreglar
        unset($data['formulario_id']);
        unset($data['usuario_id']);
        unset($data['id']);

        $resultados =[];
        foreach ($data['analisis'] as $registro) {
            $especieId = $registro['especie_id'];
            $tallas[$especieId][] = $registro['talla'];
            $pesos[$especieId][] = $registro['peso'];
        }      
        foreach ($tallas as $especieId => $arrayTallas) {
            // Calcular la talla media y moda
            $tallaMedia = round(Average::mean($arrayTallas),1);
            $tallaModa = Average::mode($arrayTallas);
            // Calcular el peso medio
            $arrayPesos = $pesos[$especieId];
            $pesoMedia = round(Average::mean($arrayPesos),1);
            // Guardar los resultados
            $resultados[] = [
                'especie_id' => $especieId,
                'talla_media' => $tallaMedia,
                'talla_moda' => $tallaModa,
                'peso_media' => $pesoMedia
            ];
        }
        $data['resultados'] = $resultados;
        $resp->json = $data;
        
        
        $resp->save();
        return response()->json([
            "id" => $resp->id,
            "msg"=> "Respuesta Ingresada",
        ] ,201);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function Query(Request $request)
    {
        // Busqueda en un JSON
        
        /*
         $respuesta = RespFormulario::where("formulario_id", 1)
                                    ->whereRaw("json->'nave_id' = '1'")
                                    ->with('nave')
                                    ->get();
                                    */
                                
        
        $respuesta = RespFormulario::where("formulario_id", 1)
                                    ->whereRaw("json->'nave_id' = '1'")
                                    ->join('naves', 'naves.id', '=', DB::raw("CAST(resp_formularios.json->>'nave_id' AS INTEGER)"))
                                    ->select('resp_formularios.*','naves.nombre as nave_nombre')
                                    ->get();
                                    
        
        

        // Busqueda con condicionales JSON
        /*
        $respuesta = RespFormulario::where("FormularioId", 1)
                            ->whereRaw("CAST(json->'nombre'->>'age' AS INTEGER) > 25")
                            ->get();
        */
        
        /*
        $respuesta = RespFormulario::where("FormularioId", 1)
                            ->whereRaw("json->'nombre'->>'genero' = 'Male'")
                            ->whereRaw("CAST(json->'nombre'->>'age' AS INTEGER) > 50")
                            ->get();
        */
        

        // FILTRADO + BUSQUEDA
        /*
        $respuesta =RespFormulario::select(
                                    'Id',
                                    'FormularioId',
                                    DB::raw("json->'nombre'->>'age' as age"),
                                    DB::raw("json->'nombre'->>'nombre' as nombre"),
                                    DB::raw("json->'nombre'->>'apellido' as apellido"),
                                    DB::raw("json->'nombre'->'hobbies' as hobbies"),
                                    DB::raw("json->'friends' as friends")
                                )
                                ->where("FormularioId", 1)
                                ->whereRaw("CAST(json->'nombre'->>'age' AS INTEGER) > 20 AND json->'nombre'->>'genero' = 'Male'")
                                ->get();
        */
        
        /*
        $respuesta = RespFormulario::select(
                                        DB::raw("AVG(CAST(json->'nombre'->>'age' AS INTEGER)) as promedio_edades")
                                    )
                                    ->where("formulario_id", 1)
                                    ->whereRaw("CAST(json->'nombre'->>'age' AS INTEGER) > 50 AND json->'nombre'->>'genero' = 'Male'")
                                    ->first();
        */                          

        return response()->json($respuesta,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
