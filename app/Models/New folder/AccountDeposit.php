<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AccountDeposit
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $description
 * @property string $payment_status
 * @property string $acc_debited_status
 * @property string|null $transaction_id
 * @property string|null $invoice_id
 * @property string|null $payment_response
 * @property string|null $card_details
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $gate_way_id
 * 
 * @property PaymentGateway $payment_gateway
 * @property User $user
 *
 * @package App\Models
 */
class AccountDeposit extends Model
{
	use SoftDeletes;
	protected $hidden  = ['deleted_at'];
	
	protected $table = 'account_deposits';

	protected $casts = [
		'user_id' => 'int',
		'gate_way_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'description',
		'payment_status',
		'acc_debited_status',
		'transaction_id',
		'invoice_id',
		'payment_response',
		'card_details',
		'gate_way_id'
	];

	public function payment_gateway()
	{
		return $this->belongsTo(PaymentGateway::class, 'gate_way_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
