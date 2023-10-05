<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * 
 * @property int $id
 * @property string $name
 * @property int $country
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|City[] $cities
 * @property Collection|Temple[] $temples
 * @property Collection|UserAddress[] $user_addresses
 *
 * @package App\Models
 */
class State extends Model
{
	protected $table = 'states';

	protected $casts = [
		'country' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'country',
		'is_active'
	];

	public function country()
	{
		return $this->belongsTo(Country::class, 'country');
	}

	public function cities()
	{
		return $this->hasMany(City::class, 'state');
	}

	public function temples()
	{
		return $this->hasMany(Temple::class, 'state');
	}

	public function user_addresses()
	{
		return $this->hasMany(UserAddress::class, 'state');
	}
}
