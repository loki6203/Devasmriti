<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EventFaq
 * 
 * @property int $id
 * @property int $event_id
 * @property string $title
 * @property string $sub_title
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Event $event
 *
 * @package App\Models
 */
class EventFaq extends Model
{
	use SoftDeletes;
	protected $table = 'event_faqs';

	protected $casts = [
		'event_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'event_id',
		'title',
		'sub_title',
		'is_active'
	];

	public function event()
	{
		return $this->belongsTo(Event::class);
	}
}
