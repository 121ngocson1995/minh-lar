<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    public function grades()
    {
        return $this->hasMany('App\Grade');
    }
    use SoftDeletes;
     protected $dates = ['deleted_at'];
}
