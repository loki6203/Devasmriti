<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * 
 * @property int $id
 * @property string $title
 * @property string $sku_code
 * @property string $event
 * @property string $location
 * @property int $banner_image
 * @property int|null $background_image
 * @property int $feature_image
 * @property Carbon $start_date
 * @property Carbon $expairy_date_time
 * @property bool $is_expaired
 * @property string|null $expairy_label
 * @property int $reward_points
 * @property string $description
 * @property string $additional_information
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 * @property Collection|EventFaq[] $event_faqs
 * @property Collection|Seva[] $sevas
 * @property Collection|EventUpdate[] $event_updates
 *
 * @package App\Models
 */
class Event extends Model
{
	protected $table = 'events';

	protected $casts = [
		'banner_image' => 'int',
		'background_image' => 'int',
		'feature_image' => 'int',
		'is_expaired' => 'bool',
		'reward_points' => 'int',
		'is_active' => 'bool'
	];

	protected $dates = [
		'start_date',
		'expairy_date_time'
	];

	protected $fillable = [
		'title',
		'sku_code',
		'event',
		'location',
		'banner_image',
		'background_image',
		'feature_image',
		'start_date',
		'expairy_date_time',
		'is_expaired',
		'expairy_label',
		'reward_points',
		'description',
		'additional_information',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'feature_image');
	}

	public function event_faqs()
	{
		return $this->hasMany(EventFaq::class, 'event');
	}

	public function sevas()
	{
		return $this->belongsToMany(Seva::class, 'event_sevas', 'event', 'seva')
					->withPivot('id', 'is_active')
					->withTimestamps();
	}

	public function event_updates()
	{
		return $this->hasMany(EventUpdate::class, 'event');
	}
}
