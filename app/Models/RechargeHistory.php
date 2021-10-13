<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RechargeHistory
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $recharge_type
 * @property string|null $operator
 * @property string $mobile_number
 * @property float|null $amount
 * @property string|null $description
 * @property string $payment_status
 * @property string $acc_debited_status
 * @property string|null $transaction_id
 * @property string|null $invoice_id
 * @property string|null $payment_response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class RechargeHistory extends Model
{
	use SoftDeletes;
	protected $hidden  = ['deleted_at'];
	
	protected $table = 'recharge_history';

	protected $casts = [
		'user_id' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'user_id',
		'recharge_type',
		'operator',
		'mobile_number',
		'amount',
		'description',
		'payment_status',
		'acc_debited_status',
		'transaction_id',
		'invoice_id',
		'payment_response'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
