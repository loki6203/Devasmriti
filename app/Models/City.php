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
 * @property string $name
 * @property int $state_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property State $state
 * @property Collection|Temple[] $temples
 * @property Collection|UserAddress[] $user_addresses
 *
 * @package App\Models
 */
class City extends Model
{
	use SoftDeletes;
	protected $table = 'cities';

	protected $casts = [
		'state_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'state_id',
		'is_active'
	];

	public function state()
	{
		return $this->belongsTo(State::class);
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
