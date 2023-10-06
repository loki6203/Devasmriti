<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Anouncement
 * 
 * @property int $id
 * @property int $seva_id
 * @property string $title
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Seva $seva
 *
 * @package App\Models
 */
class Anouncement extends Model
{
	use SoftDeletes;
	protected $table = 'anouncements';

	protected $casts = [
		'seva_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva_id',
		'title',
		'is_active'
	];

	public function seva()
	{
		return $this->belongsTo(Seva::class);
	}
}
