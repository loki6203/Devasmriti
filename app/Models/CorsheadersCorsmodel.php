<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CorsheadersCorsmodel
 * 
 * @property int $id
 * @property string $cors
 *
 * @package App\Models
 */
class CorsheadersCorsmodel extends Model
{
	protected $table = 'corsheaders_corsmodel';
	public $timestamps = false;

	protected $fillable = [
		'cors'
	];
}
