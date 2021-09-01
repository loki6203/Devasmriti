<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentGateway
 * 
 * @property int $id
 * @property string|null $name
 * @property string $is_active
 * @property float|null $gateway_charge
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PaymentGateway extends Model
{
	protected $table = 'payment_gateways';

	protected $casts = [
		'gateway_charge' => 'float'
	];

	protected $fillable = [
		'name',
		'is_active',
		'gateway_charge'
	];
}
