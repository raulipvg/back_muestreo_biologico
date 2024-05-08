<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
/**
 * Class Storage
 * 
 * @property int $id
 * @property string $nombre
 * @property string $url
 * @property int $respuesta_id
 * 
 * @property RespFormulario $solicitud
 *
 * @package App\Models
 */
class RespStorage extends Model
{
	protected $table = 'resp_storage';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'respuesta_id' => 'int'
        
	];

	protected $fillable = [
        'nombre',
		'url',
		'respuesta_id'
	];

	public function respuesta()
	{
		return $this->belongsTo(RespFormulario::class, 'respuesta_id');
	}


}
