<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Especie
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $enabled
 *
 * @package App\Models
 */
class Especie extends Model
{
	protected $table = 'especies';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'enabled' => 'bool',
		'talla_min' => 'int',
		'talla_max' => 'int',
		'peso_min' => 'int',
		'peso_max' => 'int'
	];

	protected $fillable = [
		'nombre',
		'enabled',
		'talla_min',
		'talla_max',
		'peso_min',
		'peso_max',
	
	];
}
