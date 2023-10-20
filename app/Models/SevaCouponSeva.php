<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SevaCouponSeva
 * 
 * @property int $id
 * @property int $seva_id
 * @property int $user_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Seva $seva
 * @property User $user
 *
 * @package App\Models
 */
class SevaCouponSeva extends Model
{
	use SoftDeletes;
	protected $table = 'seva_coupon_sevas';

	protected $casts = [
		'seva_id' => 'int',
		'user_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva_id',
		'user_id',
		'is_active'
	];

	public function seva()
	{
		return $this->belongsTo(Seva::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
