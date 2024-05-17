<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property string $username
 * @property string|null $password
 * @property string $email
 * @property int|null $google_id
 * @property bool $enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property int $persona_id
 *
 * @property Persona $persona
 * @package App\Models
 */
class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;
	protected $table = 'usuarios';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'id' => 'int',
		'enabled' => 'int',
		'persona_id' => 'int'
	];

	protected $fillable = [
		'username',
		'password',
		'email',
		'google_id',
		'persona_id',
		'enabled'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'persona_id');
	}

	public function getAuthPassword()
	{
		return $this->password;
	}

	public function validate(array $data)
    {
        $id = isset($data['id']) ? $data['id'] : null;

        $rules = [
            'username' => [
                'required',
                'string',
                'max:255',
				Rule::unique('usuarios','username')->ignore($id, 'id'),
            ],
			'password' => [
                'nullable',
                'string',
                'max:255'
            ],
			'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('usuarios','email')->ignore($id, 'id')
            ],
			'google_id' => 'nullable|string|numeric',
            'enabled' => 'required|min:0|max:1'
        ];
        $messages = [
            'username.unique' => 'El Username ya está en uso.',
            'email.unique' => 'El Email ya está en uso.',
            '*' => 'Hubo un problema con el campo :attribute.'
            // Agrega más mensajes personalizados aquí según tus necesidades
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $databaseErrors = $errors->getMessages();

            foreach ($databaseErrors as $fieldErrors) {
                foreach ($fieldErrors as $fieldError) {
                    if (strpos($fieldError, 'database') !== false) {
                        //Problema de BD
                        $messages['*'] = 'Error';
                        break 2; // Salir de los bucles si se encuentra un error de la base de datos
                    }
                }
            }
            throw new ValidationException($validator);
        }
    }

    public function grupoPrivilegios()
	{
        $query = DB::table('acc_usuario_grupos')
                            ->join('grupos', 'grupos.id', '=', 'acc_usuario_grupos.grupo_id')                            
                            ->where('acc_usuario_grupos.usuario_id', $this->id)
                            ->where('acc_usuario_grupos.enabled', true)
                            ->where('grupos.enabled', true);

		$queryGrupoPrivilegios = $query->select([
                                        'acc_grupo_privilegios.privilegio_id as p_id',
                                        DB::raw('bool_or(acc_grupo_privilegios.privilegio1) as p1'),
                                        DB::raw('bool_or(acc_grupo_privilegios.privilegio2) as p2'),
                                        DB::raw('bool_or(acc_grupo_privilegios.privilegio3) as p3'),
                                        DB::raw('bool_or(acc_grupo_privilegios.privilegio4) as p4'),
                                    ])
                                    ->join('acc_grupo_privilegios', 'acc_grupo_privilegios.grupo_id', '=', 'grupos.id')
                                    ->join('privilegio_maestros', 'privilegio_maestros.id', '=', 'acc_grupo_privilegios.privilegio_id')
                                    ->where('privilegio_maestros.enabled', true)
                                    ->groupBy('acc_grupo_privilegios.privilegio_id')
                                    ->get();

       
        $queryAccesoFormGrupos = $query->select([
                                            'acc_formulario_grupos.formulario_id as f_id',
                                            DB::raw('bool_or(acc_formulario_grupos.privilegio5) as p5'),
                                            DB::raw('bool_or(acc_formulario_grupos.privilegio6) as p6'),
                                            DB::raw('bool_or(acc_formulario_grupos.privilegio7) as p7'),
                                            DB::raw('bool_or(acc_formulario_grupos.privilegio8) as p8'),
                                        ])
                                        ->join('acc_formulario_grupos', 'acc_formulario_grupos.grupo_id', '=', 'grupos.id')
                                        ->groupBy('acc_formulario_grupos.formulario_id')
                                        ->get();
        
        
        return [
            'Privilegios' => $queryGrupoPrivilegios,
            'Formularios' => $queryAccesoFormGrupos
        ];
	}
}
