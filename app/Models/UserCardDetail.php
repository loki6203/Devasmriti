<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCardDetail
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $card
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class UserCardDetail extends Model
{
	protected $table = 'user_card_details';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'card'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
