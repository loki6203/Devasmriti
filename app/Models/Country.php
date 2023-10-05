<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * 
 * @property int $id
 * @property string|null $name
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|State[] $states
 * @property Collection|Temple[] $temples
 * @property Collection|UserAddress[] $user_addresses
 *
 * @package App\Models
 */
class Country extends Model
{
	protected $table = 'countries';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'is_active'
	];

	public function states()
	{
		return $this->hasMany(State::class, 'country');
	}

	public function temples()
	{
		return $this->hasMany(Temple::class, 'country');
	}

	public function user_addresses()
	{
		return $this->hasMany(UserAddress::class, 'country');
	}
}
