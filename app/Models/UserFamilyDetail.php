<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserFamilyDetail
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $family_type
 * @property string $full_name
 * @property Carbon $dob
 * @property int $relation_id
 * @property int $rasi_id
 * @property string $gothram
 * @property string $nakshatram
 * @property string $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Rasi $rasi
 * @property Relation $relation
 * @property User $user
 * @property Collection|OrderSeva[] $order_sevas
 *
 * @package App\Models
 */
class UserFamilyDetail extends Model
{
	use SoftDeletes;
	protected $table = 'user_family_details';

	protected $casts = [
		'user_id' => 'int',
		'relation_id' => 'int',
		'rasi_id' => 'int',
		'is_active' => 'bool'
	];

	protected $dates = [
		'dob'
	];

	protected $fillable = [
		'user_id',
		'family_type',
		'full_name',
		'dob',
		'relation_id',
		'rasi_id',
		'gothram',
		'nakshatram',
		'description',
		'is_active'
	];

	public function rasi()
	{
		return $this->belongsTo(Rasi::class);
	}

	public function relation()
	{
		return $this->belongsTo(Relation::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function order_sevas()
	{
		return $this->hasMany(OrderSeva::class);
	}
}
