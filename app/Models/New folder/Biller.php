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
 * Class Biller
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $ifsc_code
 * @property string|null $name
 * @property string|null $api_response
 * @property string $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $acc_number
 * @property string|null $bank_name
 * 
 * @property User $user
 * @property Collection|BillPay[] $bill_pays
 * @property Collection|RentPay[] $rent_pays
 *
 * @package App\Models
 */
class Biller extends Model
{
	use SoftDeletes;
	protected $hidden  = ['deleted_at'];

	protected $table = 'billers';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'ifsc_code',
		'name',
		'api_response',
		'is_active',
		'acc_number',
		'bank_name'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function bill_pays()
	{
		return $this->hasMany(BillPay::class);
	}

	public function rent_pays()
	{
		return $this->hasMany(RentPay::class);
	}
}