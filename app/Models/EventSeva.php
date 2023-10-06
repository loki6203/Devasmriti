<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EventSeva
 * 
 * @property int $id
 * @property int $seva_id
 * @property int $event_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Event $event
 * @property Seva $seva
 *
 * @package App\Models
 */
class EventSeva extends Model
{
	use SoftDeletes;
	protected $table = 'event_sevas';

	protected $casts = [
		'seva_id' => 'int',
		'event_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva_id',
		'event_id',
		'is_active'
	];

	public function event()
	{
		return $this->belongsTo(Event::class);
	}

	public function seva()
	{
		return $this->belongsTo(Seva::class);
	}
}
