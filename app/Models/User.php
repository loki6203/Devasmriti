<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $email
 * @property string $mobile_number
 * @property string|null $password
 * @property int|null $profile_pic
 * @property Carbon|null $dob
 * @property string|null $about_me
 * @property int|null $otp
 * @property string $user_type
 * @property bool $is_active
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image|null $image
 * @property Collection|Order[] $orders
 * @property Collection|UserAddress[] $user_addresses
 * @property Collection|UserCart[] $user_carts
 * @property Collection|UserFamilyDetail[] $user_family_details
 * @property Collection|UserReward[] $user_rewards
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'profile_pic' => 'int',
		'otp' => 'int',
		'is_active' => 'bool'
	];

	protected $dates = [
		'dob'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'fname',
		'lname',
		'email',
		'mobile_number',
		'password',
		'profile_pic',
		'dob',
		'about_me',
		'otp',
		'user_type',
		'is_active',
		'remember_token'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'profile_pic');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'user');
	}

	public function user_addresses()
	{
		return $this->hasMany(UserAddress::class, 'user');
	}

	public function user_carts()
	{
		return $this->hasMany(UserCart::class, 'user');
	}

	public function user_family_details()
	{
		return $this->hasMany(UserFamilyDetail::class, 'user');
	}

	public function user_rewards()
	{
		return $this->hasMany(UserReward::class, 'user');
	}
}
