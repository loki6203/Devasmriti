<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SevaCouponUser
 * 
 * @property int $id
 * @property int $seva_coupon_id
 * @property int $user_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Image $image
 * @property User $user
 *
 * @package App\Models
 */
class SevaCouponUser extends Model
{
	use SoftDeletes;
	protected $table = 'seva_coupon_users';

	protected $casts = [
		'seva_coupon_id' => 'int',
		'user_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva_coupon_id',
		'user_id',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'seva_coupon_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
