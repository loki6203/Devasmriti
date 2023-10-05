<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventSeva
 * 
 * @property int $id
 * @property int $seva
 * @property int $event
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class EventSeva extends Model
{
	protected $table = 'event_sevas';

	protected $casts = [
		'seva' => 'int',
		'event' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva',
		'event',
		'is_active'
	];

	public function event()
	{
		return $this->belongsTo(Event::class, 'event');
	}

	public function seva()
	{
		return $this->belongsTo(Seva::class, 'seva');
	}
}
