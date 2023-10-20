<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DjangoMigration
 * 
 * @property int $id
 * @property string $app
 * @property string $name
 * @property Carbon $applied
 *
 * @package App\Models
 */
class DjangoMigration extends Model
{
	protected $table = 'django_migrations';
	public $timestamps = false;

	protected $dates = [
		'applied'
	];

	protected $fillable = [
		'app',
		'name',
		'applied'
	];
}
