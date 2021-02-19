<?php

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{

	protected $table = "audit_trail";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','remarks','process','ip'
    ];

    public $timestamps = true;

}
