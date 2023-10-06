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
 * Class Relation
 * 
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|UserFamilyDetail[] $user_family_details
 *
 * @package App\Models
 */
class Relation extends Model
{
	use SoftDeletes;
	protected $table = 'relations';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'is_active'
	];

	public function user_family_details()
	{
		return $this->hasMany(UserFamilyDetail::class);
	}
}
