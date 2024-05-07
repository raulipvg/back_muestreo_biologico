<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nave
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $enabled
 * @property int $flota_id
 *
 * @package App\Models
 */
class Nave extends Model
{
	protected $table = 'naves';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;
	
	protected $casts = [
		'enabled' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'enabled',
		'flota_id'
	];

	public function flota()
	{
		return $this->belongsTo(Flota::class);
	}
}
