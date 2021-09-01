<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserDetail
 * 
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string|null $last_name
 * @property float $acc_balance
 * @property string|null $tpin
 * @property string|null $pan_number
 * @property string|null $adhar_number
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $mobile_verified_at
 * @property Carbon|null $pan_verified_at
 * @property Carbon|null $adhar_verified_at
 * @property string|null $pan_response
 * @property string|null $adhar_response
 * @property int $mobile_otp
 * @property int $pan_attempts
 * @property int $adhar_otp
 * @property int $email_otp
 * @property float|null $gateway_charge
 * @property float|null $referal_code_percentage
 * @property float|null $beneficiary_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class UserDetail extends Model
{
	protected $table = 'user_details';

	protected $casts = [
		'user_id' => 'int',
		'acc_balance' => 'float',
		'mobile_otp' => 'int',
		'pan_attempts' => 'int',
		'adhar_otp' => 'int',
		'email_otp' => 'int',
		'gateway_charge' => 'float',
		'referal_code_percentage' => 'float',
		'beneficiary_amount' => 'float'
	];

	protected $dates = [
		'email_verified_at',
		'mobile_verified_at',
		'pan_verified_at',
		'adhar_verified_at'
	];

	protected $fillable = [
		'user_id',
		'first_name',
		'last_name',
		'acc_balance',
		'tpin',
		'pan_number',
		'adhar_number',
		'email_verified_at',
		'mobile_verified_at',
		'pan_verified_at',
		'adhar_verified_at',
		'pan_response',
		'adhar_response',
		'mobile_otp',
		'pan_attempts',
		'adhar_otp',
		'email_otp',
		'gateway_charge',
		'referal_code_percentage',
		'beneficiary_amount'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
