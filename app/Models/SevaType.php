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
 * Class SevaType
 * 
 * @property int $id
 * @property int $featured_image_id
 * @property string $name
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $ordering_number
 * 
 * @property Image $image
 * @property Collection|Seva[] $sevas
 *
 * @package App\Models
 */
class SevaType extends Model
{
	use SoftDeletes;
	protected $table = 'seva_types';

	protected $casts = [
		'featured_image_id' => 'int',
		'is_active' => 'bool',
		'ordering_number' => 'int'
	];

	protected $fillable = [
		'featured_image_id',
		'name',
		'is_active',
		'ordering_number'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'featured_image_id');
	}

	public function sevas()
	{
		return $this->hasMany(Seva::class);
	}
}
