<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderSeva
 * 
 * @property int $id
 * @property int $order
 * @property int $seva_price
 * @property int $qty
 * @property float $base_price
 * @property float $selling_price
 * @property string|null $seva_price_information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class OrderSeva extends Model
{
	protected $table = 'order_sevas';

	protected $casts = [
		'order' => 'int',
		'seva_price' => 'int',
		'qty' => 'int',
		'base_price' => 'float',
		'selling_price' => 'float'
	];

	protected $fillable = [
		'order',
		'seva_price',
		'qty',
		'base_price',
		'selling_price',
		'seva_price_information'
	];

	public function order()
	{
		return $this->belongsTo(Order::class, 'order');
	}

	public function seva_price()
	{
		return $this->belongsTo(SevaPrice::class, 'seva_price');
	}
}
