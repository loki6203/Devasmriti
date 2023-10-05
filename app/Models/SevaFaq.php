<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SevaFaq
 * 
 * @property int $id
 * @property int $seva
 * @property string $title
 * @property string $sub_title
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class SevaFaq extends Model
{
	protected $table = 'seva_faqs';

	protected $casts = [
		'seva' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'seva',
		'title',
		'sub_title',
		'is_active'
	];

	public function seva()
	{
		return $this->belongsTo(Seva::class, 'seva');
	}
}
