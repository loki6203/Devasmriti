<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Banner
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $image_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $ordering_number
 * 
 * @property Image|null $image
 *
 * @package App\Models
 */
class Banner extends Model
{
	use SoftDeletes;
	protected $table = 'banners';

	protected $casts = [
		'image_id' => 'int',
		'is_active' => 'bool',
		'ordering_number' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'image_id',
		'is_active',
		'ordering_number'
	];

	public function image()
	{
		return $this->belongsTo(Image::class);
	}
}
