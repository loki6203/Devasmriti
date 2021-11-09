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
 * Class Country
 * 
 * @property int $id
 * @property string|null $name
 * @property string $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|City[] $cities
 * @property Collection|State[] $states
 * @property Collection|UserDetail[] $user_details
 *
 * @package App\Models
 */
class Country extends Model
{
	use SoftDeletes;
	protected $table = 'countries';

	protected $fillable = [
		'name',
		'is_active'
	];

	public function cities()
	{
		return $this->hasMany(City::class);
	}

	public function states()
	{
		return $this->hasMany(State::class);
	}

	public function user_details()
	{
		return $this->hasMany(UserDetail::class);
	}
}
