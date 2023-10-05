<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SevaUpdate
 * 
 * @property int $id
 * @property int $seva
 * @property string $title
 * @property int $file
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Image $image
 *
 * @package App\Models
 */
class SevaUpdate extends Model
{
	protected $table = 'seva_updates';

	protected $casts = [
		'seva' => 'int',
		'file' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva',
		'title',
		'file',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'file');
	}

	public function seva()
	{
		return $this->belongsTo(Seva::class, 'seva');
	}
}
