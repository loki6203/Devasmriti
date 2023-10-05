<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * 
 * @property int $id
 * @property string|null $address
 * @property float|null $common_reward_percentage
 * @property float|null $rewards_minium_cart_amount
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Setting extends Model
{
	protected $table = 'settings';

	protected $casts = [
		'common_reward_percentage' => 'float',
		'rewards_minium_cart_amount' => 'float',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'address',
		'common_reward_percentage',
		'rewards_minium_cart_amount',
		'is_active'
	];
}
