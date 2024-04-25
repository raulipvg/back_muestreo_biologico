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
 * Class Persona
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Apellido
 * @property string $Rut
 * @property int $Enabled
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'personas';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;
	
	protected $casts = [
		'id' => 'int',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'apellido',
		'rut',
		'enabled'
	];

	public function usuario()
	{
		return $this->hasOne(Usuario::class, 'personaid');
	}

	public function validate(array $data)
    {
        $id = isset($data['Id']) ? $data['Id'] : null;

        $rules = [
            'nombre' => [
                'required',
                'string',
                'max:255'
            ],
			'apellido' => [
                'required',
                'string',
                'max:255'
            ],
			'rut' => [
                'required',
                'string',
                'max:13',
                Rule::unique('persona','Rut')->ignore($id, 'Id'),
            ],
            'enabled' => 'required|min:0|max:1'
        ];
        $messages = [
            'rut.unique' => 'El Rut ya está en uso.',
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
