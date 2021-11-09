<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 * 
 * @property int $id
 * @property string|null $name
 * @property string $is_active
 * @property int $country_id
 * @property int $state_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Country $country
 * @property State $state
 * @property Collection|UserDetail[] $user_details
 *
 * @package App\Models
 */
class City extends Model
{
	use SoftDeletes;
	protected $hidden  = ['deleted_at'];
	
	protected $table = 'cities';

	protected $casts = [
		'country_id' => 'int',
		'state_id' => 'int'
	];

	protected $fillable = [
		'name',
		'is_active',
		'country_id',
		'state_id'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function state()
	{
		return $this->belongsTo(State::class);
	}

	public function user_details()
	{
		return $this->hasMany(UserDetail::class);
	}
}
