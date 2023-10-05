<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SevaCoupon
 * 
 * @property int $id
 * @property string $title
 * @property string $code
 * @property string $coupon_type
 * @property int $coupon_image
 * @property bool $is_for_new_user_only
 * @property int $per_user_limit_count
 * @property int $max_users_count
 * @property string|null $users
 * @property string|null $sevas
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class SevaCoupon extends Model
{
	protected $table = 'seva_coupons';

	protected $casts = [
		'coupon_image' => 'int',
		'is_for_new_user_only' => 'bool',
		'per_user_limit_count' => 'int',
		'max_users_count' => 'int',
		'is_active' => 'bool'
	];

	protected $dates = [
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'title',
		'code',
		'coupon_type',
		'coupon_image',
		'is_for_new_user_only',
		'per_user_limit_count',
		'max_users_count',
		'users',
		'sevas',
		'start_date',
		'end_date',
		'description',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'coupon_image');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'seva_coupon');
	}
}
