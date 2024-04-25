<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccesoFormularioGrupo
 * 
 * @property int $id
 * @property bool $privilegio5
 * @property bool $privilegio6
 * @property bool $privilegio7
 * @property bool $privilegio8
 * 
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AccesoFormularioGrupo extends Model
{
	protected $table = 'acc_formulario_grupos';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;
	
	protected $casts = [
		'privilegio5' => 'bool',
		'privilegio6' => 'bool',
		'privilegio7' => 'bool',
		'privilegio8' => 'bool',
		'formulario_id' => 'int',
		'grupo_id' => 'int'
	];

	protected $fillable = [
		'privilegio5',
		'privilegio6',
		'privilegio7',
		'privilegio8',
		'formulario_id',
		'grupo_id'
	];

	public function formulario()
	{
		return $this->belongsTo(Formulario::class, 'formulario_id');
	}

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'grupo_id');
	}	
}
