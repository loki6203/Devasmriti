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
 * Class Image
 * 
 * @property int $id
 * @property string $domain
 * @property string $url
 * @property string $Seva_Banner
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|EventUpdate[] $event_updates
 * @property Collection|Event[] $events
 * @property Collection|SevaCoupon[] $seva_coupons
 * @property Collection|SevaType[] $seva_types
 * @property Collection|SevaUpdate[] $seva_updates
 * @property Collection|Seva[] $sevas
 * @property Collection|Temple[] $temples
 * @property Collection|Testimonial[] $testimonials
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Image extends Model
{
	use SoftDeletes;
	protected $table = 'images';

	protected $fillable = [
		'domain',
		'url',
		'Seva_Banner'
	];

	public function event_updates()
	{
		return $this->hasMany(EventUpdate::class, 'file_id');
	}

	public function events()
	{
		return $this->hasMany(Event::class, 'feature_image_id');
	}

	public function seva_coupons()
	{
		return $this->hasMany(SevaCoupon::class, 'coupon_image_id');
	}

	public function seva_types()
	{
		return $this->hasMany(SevaType::class, 'featured_image_id');
	}

	public function seva_updates()
	{
		return $this->hasMany(SevaUpdate::class, 'file_id');
	}

	public function sevas()
	{
		return $this->hasMany(Seva::class, 'feature_image_id');
	}

	public function temples()
	{
		return $this->hasMany(Temple::class, 'featured_image_id');
	}

	public function testimonials()
	{
		return $this->hasMany(Testimonial::class, 'profile_pic_id');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'profile_pic_id');
	}
}
