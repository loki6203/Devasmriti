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
 * @property bool $is_prasadam_available
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $user_family_detail_id
 * @property string|null $user_family_details
 * 
 * @property Order $order
 * @property SevaPrice $seva_price
 * @property UserFamilyDetail $user_family_detail
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
		'selling_price' => 'float',
		'is_prasadam_available' => 'bool',
		'user_family_detail_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'seva_price_id',
		'qty',
		'base_price',
		'selling_price',
		'seva_price_information',
		'is_prasadam_available',
		'user_family_detail_id',
		'user_family_details'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function seva_price()
	{
		return $this->belongsTo(SevaPrice::class);
	}

	public function user_family_detail()
	{
		return $this->belongsTo(UserFamilyDetail::class);
	}
}
