<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SevaPriceFamilyDetail
 * 
 * @property int $id
 * @property string|null $family_type
 * @property int $seva_price_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property SevaPrice $seva_price
 *
 * @package App\Models
 */
class SevaPriceFamilyDetail extends Model
{
	use SoftDeletes;
	protected $table = 'seva_price_family_details';

	protected $casts = [
		'seva_price_id' => 'int'
	];

	protected $fillable = [
		'family_type',
		'seva_price_id'
	];

	public function seva_price()
	{
		return $this->belongsTo(SevaPrice::class);
	}
}
