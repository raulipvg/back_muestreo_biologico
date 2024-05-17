<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoProvilegio
 * 
 * @property int $id
 * @property int $grupo_id
 * @property int $privilegio_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $privilegio1
 * @property bool $privilegio2
 * @property bool $privilegio3
 * @property bool $privilegio4
 *
 * @package App\Models
 */
class GrupoProvilegio extends Model
{
	protected $table = 'acc_grupo_privilegios';
	protected $primaryKey = 'id';
	public $incrementing = true;
	public $timestamps = true;
	
	protected $casts = [
		'privilegio1' => 'bool',
		'privilegio2' => 'bool',
		'privilegio3' => 'bool',
		'privilegio4' => 'bool',
		'grupo_id' => 'int',
		'privilegio_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'enabled',
		'grupo_id',
		'privilegio_id',
		'privilegio1',
		'privilegio2',
		'privilegio3',
		'privilegio4'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class, 'grupo_id');
	}

	public function privilegio()
	{
		return $this->belongsTo(PrivilegioMaestro::class, 'privilegio_id');
	}
}
