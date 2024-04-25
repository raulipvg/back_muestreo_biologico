<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Planta
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $enabled
 *
 * @package App\Models
 */
class Grupo extends Model
{
	protected $table = 'grupos';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;
	
	protected $casts = [
		'id' => 'int',
		'enabled' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'descripcion',
		'enabled'
	];

	public function accesos()
	{
		return $this->hasMany(AccesoUsuarioGrupo::class, 'grupo_id');
	}
}
