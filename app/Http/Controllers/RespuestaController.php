<?php

namespace App\Http\Controllers;

use App\Models\RespFormulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function IngresarRespuesta(Request $request){
        $data = $request->all();

        $respuesta = new RespFormulario();
        $respuesta->FormularioId = $data['FormularioId'];
        $respuesta->json = json_encode($data['json']);
        $respuesta->Enabled = true;
        
        $respuesta->save();
        return response()->json([
            "Id" => $respuesta->Id,
            "Msg"=> "Respuesta Ingresada",
        ] ,201);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function Query(Request $request)
    {
        // Busqueda en un JSON
        /*
        $respuesta = RespFormulario::where("FormularioId", 1)
                                ->whereJsonContains("json->nombre->age", 68)
                                ->get();
        */
        

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
        
        
        $respuesta = RespFormulario::select(
                                        DB::raw("AVG(CAST(json->'nombre'->>'age' AS INTEGER)) as promedio_edades")
                                    )
                                    ->where("FormularioId", 1)
                                    ->whereRaw("CAST(json->'nombre'->>'age' AS INTEGER) > 50 AND json->'nombre'->>'genero' = 'Male'")
                                    ->first();
                                    

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
