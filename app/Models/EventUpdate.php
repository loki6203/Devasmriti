<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EventUpdate
 * 
 * @property int $id
 * @property int $event_id
 * @property string $title
 * @property int $file_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Event $event
 * @property Image $image
 *
 * @package App\Models
 */
class EventUpdate extends Model
{
	use SoftDeletes;
	protected $table = 'event_updates';

	protected $casts = [
		'event_id' => 'int',
		'file_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'event_id',
		'title',
		'file_id',
		'is_active'
	];

	public function event()
	{
		return $this->belongsTo(Event::class);
	}

	public function image()
	{
		return $this->belongsTo(Image::class, 'file_id');
	}
}
