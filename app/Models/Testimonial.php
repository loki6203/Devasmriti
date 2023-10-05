<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Testimonial
 * 
 * @property int $id
 * @property string $name
 * @property string $profession
 * @property int|null $profile_pic
 * @property string $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image|null $image
 *
 * @package App\Models
 */
class Testimonial extends Model
{
	protected $table = 'testimonials';

	protected $casts = [
		'profile_pic' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'profession',
		'profile_pic',
		'description',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'profile_pic');
	}
}
