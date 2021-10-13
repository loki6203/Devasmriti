<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Setting
 * 
 * @property int $id
 * @property string|null $address
 * @property string|null $emails
 * @property float|null $common_code_percentage
 * @property float|null $beneficiary_amount
 * @property string|null $site_name
 * @property string|null $site_email
 * @property string|null $site_logo
 * @property string|null $site_phone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Setting extends Model
{
	use SoftDeletes;
	protected $hidden  = ['deleted_at'];
	
	protected $table = 'settings';

	protected $casts = [
		'common_code_percentage' => 'float',
		'beneficiary_amount' => 'float'
	];

	protected $fillable = [
		'address',
		'emails',
		'common_code_percentage',
		'beneficiary_amount',
		'site_name',
		'site_email',
		'site_logo',
		'site_phone'
	];
}
