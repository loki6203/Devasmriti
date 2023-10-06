<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderSeva
 * 
 * @property int $id
 * @property int $order_id
 * @property int $seva_price_id
 * @property int $qty
 * @property float $base_price
 * @property float $selling_price
 * @property string|null $seva_price_information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Order $order
 * @property SevaPrice $seva_price
 *
 * @package App\Models
 */
class OrderSeva extends Model
{
	use SoftDeletes;
	protected $table = 'order_sevas';

	protected $casts = [
		'order_id' => 'int',
		'seva_price_id' => 'int',
		'qty' => 'int',
		'base_price' => 'float',
		'selling_price' => 'float'
	];

	protected $fillable = [
		'order_id',
		'seva_price_id',
		'qty',
		'base_price',
		'selling_price',
		'seva_price_information'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function seva_price()
	{
		return $this->belongsTo(SevaPrice::class);
	}
}
