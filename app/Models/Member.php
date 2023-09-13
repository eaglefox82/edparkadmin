<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Roll;
use App\Models\Rollmapping;
use App\Models\Srequest;
use App\Models\Flight;
use App\Models\Points;
use App\Models\Eventroll;
use App\Models\Events;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'membership_number', 'first_name', 'last_name', 'rank', 'date_joined', 'date_birth', 'active'
    ];

    public function getAgeAttribute()
    {
        $now = Carbon::now();
        $age = (Carbon::parse(date('Y-m-d', strtotime($this->date_birth)))->DiffinMonths($now))/12;
        return $age;
    }

    public function getServieAttribute()
    {
        $now = Carbon::now();
        $servoce = (Carbon::parse(date("Y-m-d", strtotime($this->date_joined)))->DiffInMonths($now))/12;
        return $service;
    }




}


