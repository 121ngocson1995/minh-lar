<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'age'];

    public function grades()
    {
        return $this->hasMany('App\Grade');
    }
    use SoftDeletes;
}
