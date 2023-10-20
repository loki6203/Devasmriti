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
 * Class Seva
 * 
 * @property int $id
 * @property string $title
 * @property string $sku_code
 * @property string $event
 * @property string $location
 * @property int $banner_image_id
 * @property int|null $background_image_id
 * @property int $feature_image_id
 * @property int $temple_id
 * @property int $seva_type_id
 * @property Carbon $start_date
 * @property Carbon $expairy_date
 * @property bool $is_expaired
 * @property string|null $expairy_label
 * @property string $extracharges_label
 * @property int $extracharges_percentage
 * @property int $reward_points
 * @property string $description
 * @property string $additional_information
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Image $image
 * @property SevaType $seva_type
 * @property Temple $temple
 * @property Collection|Anouncement[] $anouncements
 * @property Collection|Event[] $events
 * @property Collection|SevaCouponSeva[] $seva_coupon_sevas
 * @property Collection|SevaFaq[] $seva_faqs
 * @property Collection|SevaPrice[] $seva_prices
 * @property Collection|SevaUpdate[] $seva_updates
 * @property Collection|UserCart[] $user_carts
 *
 * @package App\Models
 */
class Seva extends Model
{
	use SoftDeletes;
	protected $table = 'sevas';

	protected $casts = [
		'banner_image_id' => 'int',
		'background_image_id' => 'int',
		'feature_image_id' => 'int',
		'temple_id' => 'int',
		'seva_type_id' => 'int',
		'is_expaired' => 'bool',
		'extracharges_percentage' => 'int',
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
		'banner_image_id',
		'background_image_id',
		'feature_image_id',
		'temple_id',
		'seva_type_id',
		'start_date',
		'expairy_date',
		'is_expaired',
		'expairy_label',
		'extracharges_label',
		'extracharges_percentage',
		'reward_points',
		'description',
		'additional_information',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'feature_image_id');
	}

	public function seva_type()
	{
		return $this->belongsTo(SevaType::class);
	}

	public function temple()
	{
		return $this->belongsTo(Temple::class);
	}

	public function anouncements()
	{
		return $this->hasMany(Anouncement::class);
	}

	public function events()
	{
		return $this->belongsToMany(Event::class, 'event_sevas')
					->withPivot('id', 'is_active', 'deleted_at')
					->withTimestamps();
	}

	public function seva_coupon_sevas()
	{
		return $this->hasMany(SevaCouponSeva::class);
	}

	public function seva_faqs()
	{
		return $this->hasMany(SevaFaq::class);
	}

	public function seva_prices()
	{
		return $this->hasMany(SevaPrice::class);
	}

	public function seva_updates()
	{
		return $this->hasMany(SevaUpdate::class);
	}

	public function user_carts()
	{
		return $this->hasMany(UserCart::class);
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
