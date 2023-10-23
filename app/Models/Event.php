<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event
 * 
 * @property int $id
 * @property string $title
 * @property string $sku_code
 * @property string $event
 * @property string $location
 * @property int $banner_image_id
 * @property int|null $background_image_id
 * @property int $feature_image_id
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
 * @property string|null $deleted_at
 * @property bool $is_featured
 * @property int $ordering_number
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
	use SoftDeletes;
	protected $table = 'events';

	protected $casts = [
		'banner_image_id' => 'int',
		'background_image_id' => 'int',
		'feature_image_id' => 'int',
		'is_expaired' => 'bool',
		'reward_points' => 'int',
		'is_active' => 'bool',
		'is_featured' => 'bool',
		'ordering_number' => 'int'
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
		'banner_image_id',
		'background_image_id',
		'feature_image_id',
		'start_date',
		'expairy_date_time',
		'is_expaired',
		'expairy_label',
		'reward_points',
		'description',
		'additional_information',
		'is_active',
		'is_featured',
		'ordering_number'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'feature_image_id');
	}

	public function event_faqs()
	{
		return $this->hasMany(EventFaq::class);
	}

	public function sevas()
	{
		return $this->belongsToMany(Seva::class, 'event_sevas')
					->withPivot('id', 'is_active', 'deleted_at')
					->withTimestamps();
	}

	public function event_updates()
	{
		return $this->hasMany(EventUpdate::class);
	}

	public function banner_image_id()
	{
		return $this->belongsTo(Image::class, 'banner_image_id');
	}

	public function background_image_id()
	{
		return $this->belongsTo(Image::class, 'background_image_id');
	}

	public function feature_image_id()
	{
		return $this->belongsTo(Image::class, 'feature_image_id');
	}

}
