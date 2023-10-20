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
 * Class Temple
 * 
 * @property int $id
 * @property int $featured_image_id
 * @property string $name
 * @property string $code
 * @property string $about
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property int|null $pincode
 * @property string $address
 * @property int|null $latitude
 * @property int|null $longitude
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $ordering_number
 * 
 * @property City $city
 * @property Country $country
 * @property Image $image
 * @property State $state
 * @property Collection|Seva[] $sevas
 *
 * @package App\Models
 */
class Temple extends Model
{
	use SoftDeletes;
	protected $table = 'temples';

	protected $casts = [
		'featured_image_id' => 'int',
		'country_id' => 'int',
		'state_id' => 'int',
		'city_id' => 'int',
		'pincode' => 'int',
		'latitude' => 'int',
		'longitude' => 'int',
		'is_active' => 'bool',
		'ordering_number' => 'int'
	];

	protected $fillable = [
		'featured_image_id',
		'name',
		'code',
		'about',
		'country_id',
		'state_id',
		'city_id',
		'pincode',
		'address',
		'latitude',
		'longitude',
		'is_active',
		'ordering_number'
	];

	public function city()
	{
		return $this->belongsTo(City::class);
	}

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function image()
	{
		return $this->belongsTo(Image::class, 'featured_image_id');
	}

	public function state()
	{
		return $this->belongsTo(State::class);
	}

	public function sevas()
	{
		return $this->hasMany(Seva::class);
	}
}
