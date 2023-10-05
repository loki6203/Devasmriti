<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCart
 * 
 * @property int $id
 * @property string $reference_id
 * @property int|null $user
 * @property int $seva
 * @property int $seva_price
 * @property int $qty
 * @property float $base_price
 * @property float $selling_price
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class UserCart extends Model
{
	protected $table = 'user_cart';

	protected $casts = [
		'user' => 'int',
		'seva' => 'int',
		'seva_price' => 'int',
		'qty' => 'int',
		'base_price' => 'float',
		'selling_price' => 'float',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'reference_id',
		'user',
		'seva',
		'seva_price',
		'qty',
		'base_price',
		'selling_price',
		'is_active'
	];

	public function seva()
	{
		return $this->belongsTo(Seva::class, 'seva');
	}

	public function seva_price()
	{
		return $this->belongsTo(SevaPrice::class, 'seva_price');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user');
	}
}
