<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


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
class Usuario extends Model
{
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
		return $this->Password;
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
}
