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

        $file = $request->file('imagen');
        $resp = new RespFormulario();
        $resp->formulario_id = $data['formulario_id'];
        $resp->enabled = true;
        $resp->usuario_id = 1; //arreglar
        unset($data['formulario_id']);
        unset($data['usuario_id']);
        unset($data['id']);
        if(isset($data['analisis']) && count($data['analisis']) > 0){
            //$resp->json = $data;
            $resultados =[];
            foreach ($data['analisis'] as $registro) {
                $especieId = $registro['especie_id'];
                $tallas[$especieId][] = $registro['talla'];
                $pesos[$especieId][] = $registro['peso'];
                $integridad[$especieId][] = $registro['integridad'];
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
            $data['resultados'] = $resultados;
        }else{
            $data['resultados'] = [];
        }
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

    public function UploadImage(Request $request){
        try{
            $file = $request->file('imagen');
            $respuesta_id = $request->input('respuesta_id');
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

            return response()->json([
                "id" => 1,
                "msg"=> "Imagen subida",
            ] ,201);
        }catch(Exception $e){
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
            $folderName = 'muestreo_biologico_resp_id'.$respuestaId.'_' . uniqid();
    
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
