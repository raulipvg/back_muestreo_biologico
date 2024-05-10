<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use App\Models\RespFormulario;
use App\Models\RespStorage;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;
use MathPHP\Statistics\Average;
use MathPHP\Statistics\Mode;



class RespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index($formularioId = null){
        try{
            if($formularioId){
                /*
                $resp = RespFormulario::select(
                    'resp_formularios.id',
                    'naves.nombre as nave',
                    'puertos.nombre as puerto',
                    'plantas.nombre as planta',
                    DB::raw("CONCAT(personas.nombre, ' ', personas.apellido) AS persona"),
                    'resp_formularios.enabled',
                    'resp_formularios.created_at',
                    DB::raw("(SELECT STRING_AGG(CAST(value::TEXT AS VARCHAR), ',') 
                              FROM jsonb_array_elements_text(json->'especieobjetivo_id') AS elements(value)) as especieobjetivo_ids")
                )
                ->where('resp_formularios.formulario_id', $formularioId)
                ->join('naves', 'naves.id', '=', DB::raw("CAST(resp_formularios.json->>'nave_id' AS INTEGER)"))
                ->join('puertos', 'puertos.id', '=', DB::raw("CAST(resp_formularios.json->>'puerto_id' AS INTEGER)"))
                ->join('plantas', 'plantas.id', '=', DB::raw("CAST(resp_formularios.json->>'planta_id' AS INTEGER)"))
                ->join('personas', 'personas.id', '=', DB::raw("CAST(resp_formularios.json->>'persona_id' AS INTEGER)"))                 
                ->where('resp_formularios.id', 44)
                ->groupBy('resp_formularios.id', 'naves.nombre', 'puertos.nombre', 'plantas.nombre', 
                'persona', 'resp_formularios.enabled', 'resp_formularios.created_at')
                ->get();
                */

                $resp = RespFormulario::select(
                                        'resp_formularios.id',
                                        'naves.nombre as nave',
                                        'puertos.nombre as puerto',
                                        'plantas.nombre as planta',
                                        DB::raw("CONCAT(personas.nombre, ' ', personas.apellido) AS persona"),
                                        'resp_formularios.enabled',
                                        'resp_formularios.created_at'
                                    )
                                    ->where('resp_formularios.formulario_id', $formularioId)
                                    ->join('naves', 'naves.id', '=', DB::raw("CAST(resp_formularios.json->>'nave_id' AS INTEGER)"))
                                    ->join('puertos', 'puertos.id', '=', DB::raw("CAST(resp_formularios.json->>'puerto_id' AS INTEGER)"))
                                    ->join('plantas', 'plantas.id', '=', DB::raw("CAST(resp_formularios.json->>'planta_id' AS INTEGER)"))
                                    ->join('personas', 'personas.id', '=', DB::raw("CAST(resp_formularios.json->>'persona_id' AS INTEGER)"))                 
                                                  
                                    ->get();

                /*
                $results = RespFormulario::select('resp_formularios.id', 
                                                DB::raw("CAST(jsonb_array_elements_text(resp_formularios.json->'especieobjetivo_id') AS INTEGER) AS especieobjetivo_id"))
                                                ->where('formulario_id', 1)
                                                ->leftJoin('especies', function ($join) {
                                                    $join->on(DB::raw("CAST(jsonb_array_elements_text(resp_formularios.json->'especieobjetivo_id') AS INTEGER)"), '=', 'especies.id');
                                                })
                                                ->get();
                */
                $results = DB::select("WITH extracted_especieobjetivo_ids AS (
                                            SELECT resp_formularios.id, CAST(jsonb_array_elements_text(resp_formularios.json->'especieobjetivo_id') AS INTEGER) AS especieobjetivo_id
                                            FROM resp_formularios
                                            WHERE formulario_id = 1
                                        )
                                        SELECT extracted_especieobjetivo_ids.id, STRING_AGG(especies.nombre, ', ') AS nombres_especies
                                            FROM extracted_especieobjetivo_ids
                                            JOIN especies ON extracted_especieobjetivo_ids.especieobjetivo_id = especies.id
                                            GROUP BY extracted_especieobjetivo_ids.id
                            ");

                $respWithSpecies = $resp->map(function ($item) use ($results) {
                    $joinedItem = collect($results)->firstWhere('id', $item->id);
                    if ($joinedItem) {
                        $item->nombres_especies = $joinedItem->nombres_especies;
                    }
                    return $item;
                });
                $time_start = microtime(true);
                $biologico_listar = DB::select("WITH respuesta_listar AS (
                                                            SELECT 
                                                                resp_formularios.id,
                                                                naves.nombre AS nave,
                                                                puertos.nombre AS puerto,
                                                                plantas.nombre AS planta,
                                                                CONCAT(personas.nombre, ' ', personas.apellido) AS persona,
                                                                resp_formularios.enabled,
                                                                resp_formularios.created_at,
                                                                (
                                                                    SELECT STRING_AGG(especies.nombre, ', ' ORDER BY especies.nombre) AS nombres_especies
                                                                    FROM resp_formularios r
                                                                    JOIN LATERAL jsonb_array_elements_text(r.json->'especieobjetivo_id') AS especieobjetivo_id ON true
                                                                    JOIN especies ON especies.id = CAST(especieobjetivo_id AS INTEGER)
                                                                    WHERE r.id = resp_formularios.id
                                                                ) AS nombres_especies
                                                            FROM resp_formularios
                                                            JOIN naves ON naves.id = CAST(resp_formularios.json->>'nave_id' AS INTEGER)
                                                            JOIN puertos ON puertos.id = CAST(resp_formularios.json->>'puerto_id' AS INTEGER)
                                                            JOIN plantas ON plantas.id = CAST(resp_formularios.json->>'planta_id' AS INTEGER)
                                                            JOIN personas ON personas.id = CAST(resp_formularios.json->>'persona_id' AS INTEGER)
                                                            WHERE resp_formularios.formulario_id = ?
                                                        )
                                                SELECT * FROM respuesta_listar;",[1]);
                $time_end = microtime(true);
                $time = $time_end - $time_start;

                return response()->json($biologico_listar ,201);
            }else{
            
                    $resp= RespFormulario::select('resp_formularios.id','formularios.titulo',
                                                    'resp_formularios.enabled','resp_formularios.created_at')
                                                ->join('formularios','formularios.id','=','resp_formularios.formulario_id')
                                                ->get();
                    return response()->json($resp ,201);
            }
        }catch(Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ],500);
        }
    }

    public function Create(Request $request){
        
        try{
        $data = (array)json_decode($request->input('data'));        
        
        //CALCULOS DE MEDIDAS DE TENDENCIA CENTRAL, MEDIA, MODA Y PORCENTAJE DE TALLAS MENORES A
        if(isset($data['analisis']) && count($data['analisis']) > 0){
            $data['resultados'] = $this->Calculo($data['analisis']);
        }else{
            $data['resultados'] = [];
        }

        $resp = new RespFormulario();
        $resp->formulario_id = $data['formulario_id'];
        $resp->enabled = true;
        $resp->usuario_id = 1; //ARREGLAR USUARIO
        unset($data['formulario_id']);
        unset($data['usuario_id']);
        unset($data['id']);
        unset($data['imagen']);
        $resp->json = $data;
        

        DB::beginTransaction();
        $resp->save();
        $respuesta_id = $resp->id;

        $file = $request->file('imagen');
        if($file !=null){
            $urls = $this->Upload([$file],$respuesta_id);        
            if(!$urls){throw new Exception('Error en cargar archivos');}           
            $storage= [];
            foreach($urls as $url) {
                $storage[] = [
                    'url' => $url['URL'],
                    'nombre' => $url['Nombre'],
                    'respuesta_id' => $respuesta_id,
                ];
            }            
            // Insertar todas las Compuestas en un lote
            RespStorage::insert($storage);
        }
        DB::commit(); 

        return response()->json([
            "id" => $resp->id,
            "msg"=> "Respuesta Ingresada",
        ] ,201);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function Upload($files, $respuestaId){
        if ($files) {
            $result = [];
            // Crear un nombre de carpeta único
            $folderName = 'muestreo_biologico_resp_id'.$respuestaId;
    
            foreach ($files as $file) {
                // Obtener el nombre original del archivo
                $fileName = $file->getClientOriginalName();
                // Construir la ruta del archivo con la carpeta
                $filePath = $folderName . '/' . $fileName;
                // Subir archivo a Google Cloud Storage
                $storage = new StorageClient([
                    'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                    'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE')
                ]);
    
                $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
                $bucket->upload(
                                fopen($file->getPathname(), 'r'),
                                ['name' => $filePath]
                                );    
                // Obtener la URL firmada para el archivo
                //$url = $object->signedUrl(new \DateTime('tomorrow'));
                // Agregar la URL al array de URLs
                 // Agregar el nombre del archivo y la URL al resultado
                $result[] = ['Nombre' => $fileName, 'URL' => $filePath];
            }
            return $result;
        } 
        return false;
    }

    public function Get (int $id){
        try{
            $resp = RespFormulario::select('id','formulario_id','json')
                                    ->where('id',$id)
                                    ->with(['resp_storage' => function($query){
                                        $query->select('nombre','respuesta_id');
                                    }])                                  
                                    ->first(); 
                                
            RespFormulario::find($id);
            if (!$resp) {
                throw new Exception('Respuesta no encontrada');
            }
            return response()->json($resp, 201);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function Update(Request $request){
        try{
            $data = (array)json_decode($request->input('data'));

            $respEdit = RespFormulario::find($data['id']);
            if (!$respEdit) {
                throw new Exception('Respuesta no encontrada');
            }
            //CALCULOS DE MEDIDAS DE TENDENCIA CENTRAL, MEDIA, MODA Y PORCENTAJE DE TALLAS MENORES A
            if(isset($data['analisis']) && count($data['analisis']) > 0){
                $data['resultados'] = $this->Calculo($data['analisis']);
            }else{
                $data['resultados'] = [];
            }

            $respEdit->formulario_id = $data['formulario_id'];
            $respEdit->enabled = true;
            $respEdit->usuario_id = 1; //ARREGLAR USUARIO
            unset($data['formulario_id']);
            unset($data['usuario_id']);
            unset($data['id']);
            unset($data['imagen']);
            $respEdit->json = $data;

            DB::beginTransaction();
            $respEdit->save();

            $file = $request->file('imagen');
            if($file !=null){
                $urls = $this->Upload([$file],$respEdit->id);        
                if(!$urls){throw new Exception('Error en cargar archivos');}           
                $storage= [];
                foreach($urls as $url) {
                    $storage[] = [
                        'url' => $url['URL'],
                        'nombre' => $url['Nombre'],
                        'respuesta_id' => $respEdit->id,
                    ];
                }            
                // Insertar todas las Compuestas en un lote
                RespStorage::insert($storage);
            }

            DB::commit();
            
            return response()->json([
                "id" => $respEdit->id,
                "msg"=> "Respuesta Actualizada",
            ] ,201);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }  

    public function Calculo($analisis){
        $resultados =[];

            foreach ($analisis as $registro) {
                $especieId = $registro->especie_id;
                $tallas[$especieId][] = $registro->talla;
                $pesos[$especieId][] = $registro->peso;
                $integridad[$especieId][] = $registro->integridad;
            }      
            foreach ($tallas as $especieId => $arrayTallas) {
                // Calcular la talla media y moda
                $tallaMedia = round(Average::mean($arrayTallas),1);
                $tallaModa = Average::mode($arrayTallas);
                // Calcular el peso medio
                $arrayPesos = $pesos[$especieId];
                $pesoMedia = round(Average::mean($arrayPesos),1);
                $arrayintegridad = $integridad[$especieId];
                $integridadMedia = round(Average::mean($arrayintegridad),1);
                // Guardar los resultados

                $especieTallaMenor = Especie::find($especieId)->talla_menor_a;
                $totalEspecie = count($arrayTallas);
                $ntotalEspecieMenor = count(array_filter($arrayTallas, function($talla) use ($especieTallaMenor){
                    return $talla < $especieTallaMenor;
                }));
                
                $porcentaje = round(($ntotalEspecieMenor / $totalEspecie) * 100,1);

                $resultados[] = [
                    'especie_id' => $especieId,
                    'talla_media' => $tallaMedia,
                    'talla_moda' => $tallaModa,
                    'peso_media' => $pesoMedia,
                    'porc_menor_a' => $porcentaje,
                    'integridad_media' => $integridadMedia,
                ];
            }
            return $resultados;

    }
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

}
