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
 * Class SevaPrice
 * 
 * @property int $id
 * @property bool $is_default
 * @property int $seva_id
 * @property string $title
 * @property float $base_price
 * @property float $selling_price
 * @property bool $is_rewards_available
 * @property bool $is_prasadam_available
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $family_type
 * 
 * @property Seva $seva
 * @property Collection|OrderSeva[] $order_sevas
 * @property Collection|SevaPriceFamilyDetail[] $seva_price_family_details
 * @property Collection|UserCart[] $user_carts
 *
 * @package App\Models
 */
class SevaPrice extends Model
{
	use SoftDeletes;
	protected $table = 'seva_prices';

	protected $casts = [
		'is_default' => 'bool',
		'seva_id' => 'int',
		'base_price' => 'float',
		'selling_price' => 'float',
		'is_rewards_available' => 'bool',
		'is_prasadam_available' => 'bool',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'is_default',
		'seva_id',
		'title',
		'base_price',
		'selling_price',
		'is_rewards_available',
		'is_prasadam_available',
		'is_active',
		'family_type'
	];

	public function seva()
	{
		return $this->belongsTo(Seva::class);
	}

	public function order_sevas()
	{
		return $this->hasMany(OrderSeva::class);
	}

	public function seva_price_family_details()
	{
		return $this->hasMany(SevaPriceFamilyDetail::class);
	}

	public function user_carts()
	{
		return $this->hasMany(UserCart::class);
	}
}
