<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InternalTransfer
 * 
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
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
class InternalTransfer extends Model
{
	protected $table = 'internal_transfers';

	protected $casts = [
		'from_user_id' => 'int',
		'to_user_id' => 'int'
	];

	protected $fillable = [
		'from_user_id',
		'to_user_id',
		'description',
		'payment_status',
		'acc_debited_status',
		'transaction_id',
		'invoice_id',
		'payment_response'
	];
	public function from_user()
	{
		return $this->belongsTo(User::class, 'from_user_id');
	}
	public function to_user()
	{
		return $this->belongsTo(User::class, 'to_user_id');
	}
}
