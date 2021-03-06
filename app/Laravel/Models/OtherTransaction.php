<?php 

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Laravel\Traits\DateFormatter;
use Str;

class OtherTransaction extends Model{
    
    use SoftDeletes,DateFormatter;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "other_transaction";

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
        return $this->BelongsTo("App\Laravel\Models\User",'processor_user_id','id');
    }
    
    public function transac_type(){
        return $this->BelongsTo("App\Laravel\Models\OtherApplication",'type','id');
    }

    public function customer(){
        return $this->BelongsTo("App\Laravel\Models\OtherCustomer",'customer_id','id');
    }

    public function violators(){
        return $this->BelongsTo("App\Laravel\Models\Violators",'id','transaction_id');
    }
}