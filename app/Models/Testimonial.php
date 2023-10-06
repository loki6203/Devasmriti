<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Testimonial
 * 
 * @property int $id
 * @property string $name
 * @property string $profession
 * @property int|null $profile_pic_id
 * @property string $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Image|null $image
 *
 * @package App\Models
 */
class Testimonial extends Model
{
	use SoftDeletes;
	protected $table = 'testimonials';

	protected $casts = [
		'profile_pic_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'profession',
		'profile_pic_id',
		'description',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'profile_pic_id');
	}
}
