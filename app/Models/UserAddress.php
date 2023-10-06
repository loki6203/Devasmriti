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
 * Class UserAddress
 * 
 * @property int $id
 * @property int $user_id
 * @property string $fname
 * @property string $lname
 * @property string|null $email
 * @property string $phone_no
 * @property string $whatsup_no
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property string $address_1
 * @property string $address_2
 * @property int $pincode
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property City $city
 * @property Country $country
 * @property State $state
 * @property User $user
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class UserAddress extends Model
{
	use SoftDeletes;
	protected $table = 'user_addresses';

	protected $casts = [
		'user_id' => 'int',
		'country_id' => 'int',
		'state_id' => 'int',
		'city_id' => 'int',
		'pincode' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'fname',
		'lname',
		'email',
		'phone_no',
		'whatsup_no',
		'country_id',
		'state_id',
		'city_id',
		'address_1',
		'address_2',
		'pincode',
		'is_active'
	];

	public function city()
	{
		return $this->belongsTo(City::class);
	}

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function state()
	{
		return $this->belongsTo(State::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'shipping_user_address_id');
	}
}
