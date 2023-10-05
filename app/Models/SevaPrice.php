<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SevaPrice
 * 
 * @property int $id
 * @property int $seva
 * @property string $title
 * @property float $base_price
 * @property float $selling_price
 * @property bool $is_rewards_available
 * @property bool $is_prasadam_available
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|OrderSeva[] $order_sevas
 * @property Collection|UserCart[] $user_carts
 *
 * @package App\Models
 */
class SevaPrice extends Model
{
	protected $table = 'seva_prices';

	protected $casts = [
		'seva' => 'int',
		'base_price' => 'float',
		'selling_price' => 'float',
		'is_rewards_available' => 'bool',
		'is_prasadam_available' => 'bool',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva',
		'title',
		'base_price',
		'selling_price',
		'is_rewards_available',
		'is_prasadam_available',
		'is_active'
	];

	public function seva()
	{
		return $this->belongsTo(Seva::class, 'seva');
	}

	public function order_sevas()
	{
		return $this->hasMany(OrderSeva::class, 'seva_price');
	}

	public function user_carts()
	{
		return $this->hasMany(UserCart::class, 'seva_price');
	}
}
