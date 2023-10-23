<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderSevaFamilyDetail
 * 
 * @property int $id
 * @property int $order_seva_id
 * @property int $user_family_detail_id
 * @property string|null $family_details
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property OrderSeva $order_seva
 * @property UserFamilyDetail $user_family_detail
 *
 * @package App\Models
 */
class OrderSevaFamilyDetail extends Model
{
	use SoftDeletes;
	protected $table = 'order_seva_family_details';

	protected $casts = [
		'order_seva_id' => 'int',
		'user_family_detail_id' => 'int'
	];

	protected $fillable = [
		'order_seva_id',
		'user_family_detail_id',
		'family_details'
	];

	public function order_seva()
	{
		return $this->belongsTo(OrderSeva::class);
	}

	public function user_family_detail()
	{
		return $this->belongsTo(UserFamilyDetail::class);
	}
}
