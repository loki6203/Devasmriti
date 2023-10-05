<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventFaq
 * 
 * @property int $id
 * @property int $event
 * @property string $title
 * @property string $sub_title
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class EventFaq extends Model
{
	protected $table = 'event_faqs';

	protected $casts = [
		'event' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'event',
		'title',
		'sub_title',
		'is_active'
	];

	public function event()
	{
		return $this->belongsTo(Event::class, 'event');
	}
}
