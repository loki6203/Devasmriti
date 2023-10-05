<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Temple
 * 
 * @property int $id
 * @property int $featured_image
 * @property string $name
 * @property string $code
 * @property string $about
 * @property int $country
 * @property int $state
 * @property int $city
 * @property int|null $pincode
 * @property string $address
 * @property int|null $latitude
 * @property int|null $longitude
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 * @property Collection|Seva[] $sevas
 *
 * @package App\Models
 */
class Temple extends Model
{
	protected $table = 'temples';

	protected $casts = [
		'featured_image' => 'int',
		'country' => 'int',
		'state' => 'int',
		'city' => 'int',
		'pincode' => 'int',
		'latitude' => 'int',
		'longitude' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'featured_image',
		'name',
		'code',
		'about',
		'country',
		'state',
		'city',
		'pincode',
		'address',
		'latitude',
		'longitude',
		'is_active'
	];

	public function city()
	{
		return $this->belongsTo(City::class, 'city');
	}

	public function country()
	{
		return $this->belongsTo(Country::class, 'country');
	}

	public function image()
	{
		return $this->belongsTo(Image::class, 'featured_image');
	}

	public function state()
	{
		return $this->belongsTo(State::class, 'state');
	}

	public function sevas()
	{
		return $this->hasMany(Seva::class, 'temple');
	}
}
