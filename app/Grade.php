<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }
}
