<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * 
 * @property int $id
 * @property string $name
 * @property int $state
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Temple[] $temples
 * @property Collection|UserAddress[] $user_addresses
 *
 * @package App\Models
 */
class City extends Model
{
	protected $table = 'cities';

	protected $casts = [
		'state' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'state',
		'is_active'
	];

	public function state()
	{
		return $this->belongsTo(State::class, 'state');
	}

	public function temples()
	{
		return $this->hasMany(Temple::class, 'city');
	}

	public function user_addresses()
	{
		return $this->hasMany(UserAddress::class, 'city');
	}
}
