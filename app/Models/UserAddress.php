<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAddress
 * 
 * @property int $id
 * @property int $user
 * @property string $fname
 * @property string $lname
 * @property string|null $email
 * @property string $phone_no
 * @property string $whatsup_no
 * @property int $country
 * @property int $state
 * @property int $city
 * @property string $address_1
 * @property string $address_2
 * @property int $pincode
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class UserAddress extends Model
{
	protected $table = 'user_addresses';

	protected $casts = [
		'user' => 'int',
		'country' => 'int',
		'state' => 'int',
		'city' => 'int',
		'pincode' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'user',
		'fname',
		'lname',
		'email',
		'phone_no',
		'whatsup_no',
		'country',
		'state',
		'city',
		'address_1',
		'address_2',
		'pincode',
		'is_active'
	];

	public function city()
	{
		return $this->belongsTo(City::class, 'city');
	}

	public function country()
	{
		return $this->belongsTo(Country::class, 'country');
	}

	public function state()
	{
		return $this->belongsTo(State::class, 'state');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'shipping_user_address');
	}
}
