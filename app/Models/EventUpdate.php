<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventUpdate
 * 
 * @property int $id
 * @property int $event
 * @property string $title
 * @property int $file
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 *
 * @package App\Models
 */
class EventUpdate extends Model
{
	protected $table = 'event_updates';

	protected $casts = [
		'event' => 'int',
		'file' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'event',
		'title',
		'file',
		'is_active'
	];

	public function event()
	{
		return $this->belongsTo(Event::class, 'event');
	}

	public function image()
	{
		return $this->belongsTo(Image::class, 'file');
	}
}
