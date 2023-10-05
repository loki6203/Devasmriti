<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * 
 * @property int $id
 * @property string $domain
 * @property string $url
 * @property string $Seva_Banner
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
	protected $table = 'images';
	public $timestamps = false;

	protected $fillable = [
		'domain',
		'url',
		'Seva_Banner'
	];

	public function event_updates()
	{
		return $this->hasMany(EventUpdate::class, 'file');
	}

	public function events()
	{
		return $this->hasMany(Event::class, 'feature_image');
	}

	public function seva_coupons()
	{
		return $this->hasMany(SevaCoupon::class, 'coupon_image');
	}

	public function seva_types()
	{
		return $this->hasMany(SevaType::class, 'featured_image');
	}

	public function seva_updates()
	{
		return $this->hasMany(SevaUpdate::class, 'file');
	}

	public function sevas()
	{
		return $this->hasMany(Seva::class, 'feature_image');
	}

	public function temples()
	{
		return $this->hasMany(Temple::class, 'featured_image');
	}

	public function testimonials()
	{
		return $this->hasMany(Testimonial::class, 'profile_pic');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'profile_pic');
	}
}
