<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SevaUpdate
 * 
 * @property int $id
 * @property int $seva_id
 * @property string $title
 * @property int $file_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Image $image
 * @property Seva $seva
 *
 * @package App\Models
 */
class SevaUpdate extends Model
{
	use SoftDeletes;
	protected $table = 'seva_updates';

	protected $casts = [
		'seva_id' => 'int',
		'file_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva_id',
		'title',
		'file_id',
		'is_active'
	];

	public function image()
	{
		return $this->belongsTo(Image::class, 'file_id');
	}

	public function seva()
	{
		return $this->belongsTo(Seva::class);
	}
}
