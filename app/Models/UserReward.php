<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserReward
 * 
 * @property int $id
 * @property int $user_id
 * @property bool $is_credited
 * @property int $points
 * @property int $order_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Order $order
 * @property User $user
 *
 * @package App\Models
 */
class UserReward extends Model
{
	use SoftDeletes;
	protected $table = 'user_rewards';

	protected $casts = [
		'user_id' => 'int',
		'is_credited' => 'bool',
		'points' => 'int',
		'order_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'is_credited',
		'points',
		'order_id',
		'is_active'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
