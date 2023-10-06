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
 * Class State
 * 
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Country $country
 * @property Collection|City[] $cities
 * @property Collection|Temple[] $temples
 * @property Collection|UserAddress[] $user_addresses
 *
 * @package App\Models
 */
class State extends Model
{
	use SoftDeletes;
	protected $table = 'states';

	protected $casts = [
		'country_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'country_id',
		'is_active'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function cities()
	{
		return $this->hasMany(City::class);
	}

	public function temples()
	{
		return $this->hasMany(Temple::class);
	}

	public function user_addresses()
	{
		return $this->hasMany(UserAddress::class);
	}
}
