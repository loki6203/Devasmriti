<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SevaType
 * 
 * @property int $id
 * @property int $featured_image
 * @property string $name
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 * @property Collection|Seva[] $sevas
 *
 * @package App\Models
 */
class SevaType extends Model
{
	protected $table = 'seva_types';

	protected $casts = [
		'featured_image' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'featured_image',
		'name',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'featured_image');
	}

	public function sevas()
	{
		return $this->hasMany(Seva::class, 'seva_type');
	}
}
