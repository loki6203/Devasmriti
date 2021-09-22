<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountHistory
 * 
 * @property int $id
 * @property int $user_id
 * @property float|null $amount
 * @property string|null $cr_or_dr
 * @property string|null $action_type
 * @property string|null $description
 * @property int $transaction_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $payment_details
 * 
 * @property User $user
 *
 * @package App\Models
 */
class AccountHistory extends Model
{
	protected $table = 'account_history';

	protected $casts = [
		'user_id' => 'int',
		'amount' => 'float',
		'transaction_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'amount',
		'cr_or_dr',
		'action_type',
		'description',
		'transaction_id',
		'payment_details'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
