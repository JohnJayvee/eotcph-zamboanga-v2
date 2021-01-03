<?php

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationBusinessPermit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['is_posted_on_local', 'permit_no'];

   public function business()
   {
       return $this->hasOne(BusinessTransaction::class, 'business_permit_id');
   }
}
