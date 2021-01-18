<?php

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Laravel\Traits\DateFormatter;
use Str;

class Business extends Model{

    use SoftDeletes,DateFormatter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "business";

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

    public function getBusinessAddressAttribute(){
        return Str::title("{$this->unit_no} {$this->street_address} ");
    }

    public function getOwnerNameAttribute(){
        return Str::title("{$this->owner_fname} {$this->owner_mname} {$this->owner_lname}");
    }

    public function getOwnerAddressAttribute(){
        return Str::title((strlen($this->owner_unit_no) > 0 ? " ".$this->owner_unit_no : NULL)." {$this->owner_street} {$this->owner_brgy_name}");
    }

    public function getTaxIncentiveDisplayAttribute(){
        return !empty($this->tax_incentive) ? ($this->tax_incentive != "no" ? "Yes, ". Str::title("{$this->tax_incentive}") : "No"  ) : "No";
    }

    public function getForRemovalAttribute(){
        $transactions = $this->business_transaction()->where(function($q){
            $q->where('status', 'PENDING')
              ->orWhere('status', 'APPROVED');
        })->where(function($q){
            $q->where('payment_status', 'PAID')
            ->orWhere('payment_status', 'UNPAID');
        })->get();
        if($transactions->count() >= 1){
            return FALSE;
        }
        return TRUE;
    }

    public function getRenewalReadyAttribute()
    {
        // This is bound to break someday without permit expiry date not being final
        // what to do? check the latest approved permit then add year(1) to the date, then do the query again
        $transactions = $this->business_transaction()->where('created_at', 'LIKE', now()->format('Y') .'-%')->where('application_name', 'Business Permit')->where(function($q){
            $q->where('status', 'PENDING')
              ->orWhere('status', 'APPROVED');
        })->where(function($q){
            $q->where('payment_status', 'PAID')
            ->orWhere('payment_status', 'UNPAID');
        })->get();
        if($transactions->count() >= 1){
            return array(
                'flag' => FALSE,
                'last_data' => strtoupper($transactions->first()->status),
            );
        }
        return array(
            'flag' => TRUE,
            'last_data' => '',
        );
    }

    public function getBusinessFullAddressAttribute(){
        return Str::title((strlen($this->unit_no) > 0 ? " ".$this->unit_no : NULL)." {$this->street_address}, {$this->brgy_name}, {$this->town_name}");
    }

    public function owner(){
        return $this->BelongsTo("App\Laravel\Models\Customer",'customer_id','id');
    }

    public function permit(){
        return $this->BelongsTo("App\Laravel\Models\ApplicationBusinessPermit",'id','business_id');
    }

    public function business_transaction(){
        return $this->BelongsTo("App\Laravel\Models\BusinessTransaction",'id','business_id');
    }

    public function scopeKeyword($query,$keyword = NULL){
        if($keyword){
            return $query->whereRaw("LOWER(business_name) LIKE '%{$keyword}%'");
        }
    }

    public function getRepFullNameAttribute(){
        return Str::title("{$this->rep_firstname} {$this->rep_middlename} {$this->rep_lastname} ");
    }

}
