<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Formulario
 * 
 * @property int $id
 * @property string $titulo
 * @property string|null $descripcion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $enabled
 * 
 * @property Collection|RespFormulario[] $resp_formularios
 *
 * @package App\Models
 */
class Formulario extends Model
{
	protected $table = 'formularios';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'enabled' => 'bool'
	];

	protected $fillable = [
		'titulo',
		'descripcion',
		'enabled'
	];

	public function resp_formularios()
	{
		return $this->hasMany(RespFormulario::class, 'FormularioId');
	}
}
