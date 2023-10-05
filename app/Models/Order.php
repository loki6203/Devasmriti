<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property int $user
 * @property int $shipping_user_address
 * @property string|null $shipping_address
 * @property int $billing_user_address
 * @property string|null $billing_address
 * @property string $booking_type
 * @property string $payment_status
 * @property string $reference_id
 * @property string $invoice_id
 * @property string|null $transaction_id
 * @property float $org_price
 * @property float $reward_points
 * @property int|null $seva_coupon
 * @property float $coupon_amount
 * @property string|null $coupon_information
 * @property float $final_paid_amount
 * @property string|null $transaction_response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property UserAddress $user_address
 * @property Collection|OrderSeva[] $order_sevas
 * @property Collection|UserReward[] $user_rewards
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';

	protected $casts = [
		'user' => 'int',
		'shipping_user_address' => 'int',
		'billing_user_address' => 'int',
		'org_price' => 'float',
		'reward_points' => 'float',
		'seva_coupon' => 'int',
		'coupon_amount' => 'float',
		'final_paid_amount' => 'float'
	];

	protected $fillable = [
		'user',
		'shipping_user_address',
		'shipping_address',
		'billing_user_address',
		'billing_address',
		'booking_type',
		'payment_status',
		'reference_id',
		'invoice_id',
		'transaction_id',
		'org_price',
		'reward_points',
		'seva_coupon',
		'coupon_amount',
		'coupon_information',
		'final_paid_amount',
		'transaction_response'
	];

	public function user_address()
	{
		return $this->belongsTo(UserAddress::class, 'shipping_user_address');
	}

	public function seva_coupon()
	{
		return $this->belongsTo(SevaCoupon::class, 'seva_coupon');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user');
	}

	public function order_sevas()
	{
		return $this->hasMany(OrderSeva::class, 'order');
	}

	public function user_rewards()
	{
		return $this->hasMany(UserReward::class, 'order');
	}
}
