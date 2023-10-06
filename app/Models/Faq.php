<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Faq
 * 
 * @property int $id
 * @property string $title
 * @property string $sub_title
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Faq extends Model
{
	use SoftDeletes;
	protected $table = 'faqs';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'title',
		'sub_title',
		'is_active'
	];
}
