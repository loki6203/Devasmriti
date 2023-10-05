<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserReward
 * 
 * @property int $id
 * @property int $user
 * @property bool $is_credited
 * @property int $points
 * @property int $order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class UserReward extends Model
{
	protected $table = 'user_rewards';

	protected $casts = [
		'user' => 'int',
		'is_credited' => 'bool',
		'points' => 'int',
		'order' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'user',
		'is_credited',
		'points',
		'order',
		'is_active'
	];

	public function order()
	{
		return $this->belongsTo(Order::class, 'order');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user');
	}
}
