<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DjangoSession
 * 
 * @property string $session_key
 * @property string $session_data
 * @property Carbon $expire_date
 *
 * @package App\Models
 */
class DjangoSession extends Model
{
	protected $table = 'django_session';
	protected $primaryKey = 'session_key';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'expire_date'
	];

	protected $fillable = [
		'session_data',
		'expire_date'
	];
}
