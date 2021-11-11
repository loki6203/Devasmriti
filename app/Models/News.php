<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $action_type
 * @property int $action_type_id
 * @property string $message
 * @property string|null $documents
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class News extends Model
{
	protected $table = 'news';

	protected $casts = [
		'user_id' => 'int',
		'action_type_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'action_type',
		'action_type_id',
		'message',
		'documents'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
