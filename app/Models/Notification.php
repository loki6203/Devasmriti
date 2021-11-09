<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notification
 * 
 * @property int $id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $action_type
 * @property bool $is_read
 * @property string $message
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Notification extends Model
{
	use SoftDeletes;
	protected $table = 'notifications';

	protected $casts = [
		'user_id' => 'int',
		'is_read' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'action_type',
		'is_read',
		'message'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
