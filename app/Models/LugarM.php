<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarM
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $enabled
 *
 * @package App\Models
 */
class LugarM extends Model
{
	protected $table = 'lugar_m';
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
