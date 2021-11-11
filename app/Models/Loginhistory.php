<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loginhistory
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $address
 * @property string $ipaddress
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Loginhistory extends Model
{
	protected $table = 'loginhistory';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'address',
		'ipaddress'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
