<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Seva
 * 
 * @property int $id
 * @property string $title
 * @property string $sku_code
 * @property string $event
 * @property string $location
 * @property int $banner_image
 * @property int|null $background_image
 * @property int $feature_image
 * @property int $temple
 * @property int $seva_type
 * @property Carbon $start_date
 * @property Carbon $expairy_date
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
 * @property Collection|Anouncement[] $anouncements
 * @property Collection|Event[] $events
 * @property Collection|SevaFaq[] $seva_faqs
 * @property Collection|SevaPrice[] $seva_prices
 * @property Collection|SevaUpdate[] $seva_updates
 * @property Collection|UserCart[] $user_carts
 *
 * @package App\Models
 */
class Seva extends Model
{
	protected $table = 'sevas';

	protected $casts = [
		'banner_image' => 'int',
		'background_image' => 'int',
		'feature_image' => 'int',
		'temple' => 'int',
		'seva_type' => 'int',
		'is_expaired' => 'bool',
		'reward_points' => 'int',
		'is_active' => 'bool'
	];

	protected $dates = [
		'start_date',
		'expairy_date'
	];

	protected $fillable = [
		'title',
		'sku_code',
		'event',
		'location',
		'banner_image',
		'background_image',
		'feature_image',
		'temple',
		'seva_type',
		'start_date',
		'expairy_date',
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

	public function seva_type()
	{
		return $this->belongsTo(SevaType::class, 'seva_type');
	}

	public function temple()
	{
		return $this->belongsTo(Temple::class, 'temple');
	}

	public function anouncements()
	{
		return $this->hasMany(Anouncement::class, 'seva');
	}

	public function events()
	{
		return $this->belongsToMany(Event::class, 'event_sevas', 'seva', 'event')
					->withPivot('id', 'is_active')
					->withTimestamps();
	}

	public function seva_faqs()
	{
		return $this->hasMany(SevaFaq::class, 'seva');
	}

	public function seva_prices()
	{
		return $this->hasMany(SevaPrice::class, 'seva');
	}

	public function seva_updates()
	{
		return $this->hasMany(SevaUpdate::class, 'seva');
	}

	public function user_carts()
	{
		return $this->hasMany(UserCart::class, 'seva');
	}
}
