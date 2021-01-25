<?php

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Laravel\Traits\DateFormatter;
use Str;

class BusinessTransaction extends Model{

    use SoftDeletes,DateFormatter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "business_transaction";

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
    protected $guarded = [];


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



    public function getAdminDeleteAttribute()
    {
        $admin = User::find($this->deleted_by);
        if($admin){
            return $admin == 'customer' ? 'customer' : ($admin->fname . ' ' .$admin->lname);
        }
        return '';
    }

    public function owner(){
        return $this->BelongsTo("App\Laravel\Models\Customer",'owners_id','id');
    }
    public function business_info(){
        return $this->BelongsTo("App\Laravel\Models\Business",'business_id','id');
    }
     public function application_permit(){
        return $this->BelongsTo("App\Laravel\Models\ApplicationBusinessPermit",'business_permit_id','id');
    }
    public function type(){
        return $this->BelongsTo("App\Laravel\Models\Application",'application_id','id');
    }

    public function department(){
        return $this->belongsToMany('App\Laravel\Models\Department');
    }
     public function admin(){
        return $this->BelongsTo("App\Laravel\Models\User",'processor_user_id','id');
    }


}
