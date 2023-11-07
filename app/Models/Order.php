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
 * Class Order
 * 
 * @property int $id
 * @property int $user_id
 * @property int $shipping_user_address_id
 * @property string|null $shipping_address
 * @property int $billing_user_address_id
 * @property string|null $billing_address
 * @property string $booking_type
 * @property string $payment_status
 * @property string $reference_id
 * @property string $invoice_id
 * @property string|null $transaction_id
 * @property float $original_price
 * @property float $extra_charges
 * @property float $reward_points
 * @property int|null $seva_coupon_id
 * @property float $coupon_amount
 * @property string|null $coupon_information
 * @property float $final_paid_amount
 * @property string|null $transaction_response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property UserAddress $user_address
 * @property SevaCoupon|null $seva_coupon
 * @property User $user
 * @property Collection|OrderSeva[] $order_sevas
 * @property Collection|UserReward[] $user_rewards
 *
 * @package App\Models
 */
class Order extends Model
{
	use SoftDeletes;
	protected $table = 'orders';

	protected $casts = [
		'user_id' => 'int',
		'shipping_user_address_id' => 'int',
		'billing_user_address_id' => 'int',
		'original_price' => 'float',
		'extra_charges' => 'float',
		'reward_points' => 'float',
		'seva_coupon_id' => 'int',
		'coupon_amount' => 'float',
		'final_paid_amount' => 'float'
	];

	protected $fillable = [
		'user_id',
		'shipping_user_address_id',
		'shipping_address',
		'billing_user_address_id',
		'billing_address',
		'booking_type',
		'payment_status',
		'reference_id',
		'invoice_id',
		'transaction_id',
		'original_price',
		'extra_charges',
		'reward_points',
		'seva_coupon_id',
		'coupon_amount',
		'coupon_information',
		'final_paid_amount',
		'transaction_response'
	];

	public function user_address()
	{
		return $this->belongsTo(UserAddress::class, 'shipping_user_address_id');
	}

	public function seva_coupon()
	{
		return $this->belongsTo(SevaCoupon::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function order_sevas()
	{
		return $this->hasMany(OrderSeva::class);
	}

	public function user_rewards()
	{
		return $this->hasMany(UserReward::class);
	}

	public function user_billing()
	{
		return $this->belongsTo(UserAddress::class, 'billing_user_address_id');
	}
}
