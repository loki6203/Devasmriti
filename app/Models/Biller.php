<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
 * 
 * @property User $user
 * @property Collection|BillPay[] $bill_pays
 * @property Collection|RentPay[] $rent_pays
 *
 * @package App\Models
 */
class Biller extends Model
{
	protected $table = 'billers';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'ifsc_code',
		'name',
		'api_response',
		'is_active'
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
