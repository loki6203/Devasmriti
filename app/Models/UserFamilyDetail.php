<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFamilyDetail
 * 
 * @property int $id
 * @property int $user
 * @property string|null $family_type
 * @property string $full_name
 * @property Carbon $dob
 * @property int $relation
 * @property int $rasi
 * @property string $gothram
 * @property string $nakshatram
 * @property string $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class UserFamilyDetail extends Model
{
	protected $table = 'user_family_details';

	protected $casts = [
		'user' => 'int',
		'relation' => 'int',
		'rasi' => 'int',
		'is_active' => 'bool'
	];

	protected $dates = [
		'dob'
	];

	protected $fillable = [
		'user',
		'family_type',
		'full_name',
		'dob',
		'relation',
		'rasi',
		'gothram',
		'nakshatram',
		'description',
		'is_active'
	];

	public function rasi()
	{
		return $this->belongsTo(Rasi::class, 'rasi');
	}

	public function relation()
	{
		return $this->belongsTo(Relation::class, 'relation');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user');
	}
}
