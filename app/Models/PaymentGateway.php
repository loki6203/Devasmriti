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
 * Class PaymentGateway
 * 
 * @property int $id
 * @property string|null $name
 * @property string $is_active
 * @property float|null $gateway_charge
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $type
 * @property string|null $keys
 * 
 * @property Collection|AccountDeposit[] $account_deposits
 *
 * @package App\Models
 */
class PaymentGateway extends Model
{
	use SoftDeletes;
	protected $hidden  = ['deleted_at'];
	
	protected $table = 'payment_gateways';

	protected $casts = [
		'gateway_charge' => 'float'
	];

	protected $fillable = [
		'name',
		'is_active',
		'gateway_charge',
		'type',
		'keys'
	];

	public function account_deposits()
	{
		return $this->hasMany(AccountDeposit::class, 'gate_way_id');
	}
}
