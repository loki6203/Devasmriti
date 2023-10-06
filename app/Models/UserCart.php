<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserCart
 * 
 * @property int $id
 * @property string $reference_id
 * @property int|null $user_id
 * @property int $seva_id
 * @property int $seva_price_id
 * @property int $qty
 * @property float $base_price
 * @property float $selling_price
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Seva $seva
 * @property SevaPrice $seva_price
 * @property User|null $user
 *
 * @package App\Models
 */
class UserCart extends Model
{
	use SoftDeletes;
	protected $table = 'user_cart';

	protected $casts = [
		'user_id' => 'int',
		'seva_id' => 'int',
		'seva_price_id' => 'int',
		'qty' => 'int',
		'base_price' => 'float',
		'selling_price' => 'float',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'reference_id',
		'user_id',
		'seva_id',
		'seva_price_id',
		'qty',
		'base_price',
		'selling_price',
		'is_active'
	];

	public function seva()
	{
		return $this->belongsTo(Seva::class);
	}

	public function seva_price()
	{
		return $this->belongsTo(SevaPrice::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
