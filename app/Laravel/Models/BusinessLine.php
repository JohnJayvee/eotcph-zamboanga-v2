<?php

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLine extends Model
{
    protected $table = "business_line";


    protected $fillable = ['business_id','name'];

    public $timestamps = true;
}
