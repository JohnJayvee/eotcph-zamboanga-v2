<?php 

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Laravel\Traits\DateFormatter;
use Str;

class BlockList extends Model{
	
	use SoftDeletes,DateFormatter;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = "block_list";

	/**
	 * The database connection used by the model.
	 *
	 * @var string
	 */
	protected $connection = "master_db";

	/**
	 * Enable soft delete in table
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes that created within the model.
	 *
	 * @var array
	 */
	protected $appends = [];

	protected $dates = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
	];

	public function admin(){
        return $this->BelongsTo("App\Laravel\Models\User",'blocked_by','id');
    }

}