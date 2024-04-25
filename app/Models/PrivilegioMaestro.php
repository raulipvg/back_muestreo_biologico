<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PrivilegioMaestro
 * 
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $enabled
 *
 * @package App\Models
 */
class PrivilegioMaestro extends Model
{
	protected $table = 'privilegio_maestros';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;
	
	protected $casts = [
		'enabled' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'enabled'
	];
}
