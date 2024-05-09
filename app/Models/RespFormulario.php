<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class RespFormulario
 * 
 * @property int $id
 * @property int $formulario_id
 * @property json $json
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $enabled
 * @property int $usuario_id
 * 
 * @property Formulario $formulario
 *
 * @package App\Models
 */
class RespFormulario extends Model
{
	protected $table = 'resp_formularios';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'formulario_id' => 'int',
		'json' => 'json',
		'enabled' => 'bool',
		'usuario_id' => 'int'

	];

	protected $fillable = [
		'formulario_id',
		'json',
		'enabled',
		'usuario_id'
	];

	public function formulario()
	{
		return $this->belongsTo(Formulario::class, 'formulario_id');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuario_id');
	}
	public function nave()
	{
		return $this->belongsTo(Nave::class, 'json->>nave_id');

	}

	public function resp_storage()
	{
		return $this->hasMany(RespStorage::class, 'respuesta_id');
	}


	public function getNave()
	{
		$nave = DB::table('naves')->where('id', $this->json['nave_id'])->first();
		return $nave;
	}

}
