<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    public function sem_grades()
    {
        return $this->hasMany('App\Grade');
    }
}
