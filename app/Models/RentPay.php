<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RentPay
 * 
 * @property int $id
 * @property int $user_id
 * @property int $biller_id
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
 * @property Biller $biller
 * @property User $user
 *
 * @package App\Models
 */
class RentPay extends Model
{
	protected $table = 'rent_pay';

	protected $casts = [
		'user_id' => 'int',
		'biller_id' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'user_id',
		'biller_id',
		'amount',
		'description',
		'payment_status',
		'acc_debited_status',
		'transaction_id',
		'invoice_id',
		'payment_response'
	];

	public function biller()
	{
		return $this->belongsTo(Biller::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
