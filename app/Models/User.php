<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobile_number
 * @property string $password
 * @property string|null $company_name
 * @property string $user_type
 * @property string|null $referel_code
 * @property string|null $profile_pic
 * @property string $is_active
 * @property string|null $about_me
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|AccountDeposit[] $account_deposits
 * @property Collection|AccountHistory[] $account_histories
 * @property Collection|BillPay[] $bill_pays
 * @property Collection|Biller[] $billers
 * @property Collection|InternalTransfer[] $internal_transfers
 * @property Collection|Notification[] $notifications
 * @property Collection|RechargeHistory[] $recharge_histories
 * @property Collection|RentPay[] $rent_pays
 * @property Collection|UserDetail[] $user_details
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'mobile_number',
		'password',
		'company_name',
		'user_type',
		'referel_code',
		'profile_pic',
		'is_active',
		'about_me',
		'remember_token'
	];

	public function account_deposits()
	{
		return $this->hasMany(AccountDeposit::class);
	}

	public function account_histories()
	{
		return $this->hasMany(AccountHistory::class);
	}

	public function bill_pays()
	{
		return $this->hasMany(BillPay::class);
	}

	public function billers()
	{
		return $this->hasMany(Biller::class);
	}

	public function internal_transfers()
	{
		return $this->hasMany(InternalTransfer::class, 'to_user_id');
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}

	public function recharge_histories()
	{
		return $this->hasMany(RechargeHistory::class);
	}

	public function rent_pays()
	{
		return $this->hasMany(RentPay::class);
	}

	public function user_details()
	{
		return $this->hasMany(UserDetail::class);
	}
}
