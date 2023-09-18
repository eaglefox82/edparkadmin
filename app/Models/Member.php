<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'cert_no', 'last_name', 'first_name', 'dob', 'doj', 'type', 'annual_subs', 'squadron_id', 'wing_id', 'group_id', 'active', 'gender', 'current_rank'
    ];

    protected $appends = array('Unit', 'Age', 'Service', 'DefaultRank', 'Status', 'GenderString');

    public function getGenderStringAttribute()
    {
        switch ($this->gender)
        {
            case 0:
                return 'Not Known';

            case 1:
                return 'Male';

            case 2:
                return 'Female';

            case 9:
                return 'N/A';
        }

        return '';
    }

    public function getUnitAttribute()
    {
        //Get Unit Name
        if ($this->squadron != null) {
            return $this->squadron->name;
        } else if ($this->wing != null) {
            return $this->wing->name;
        } else if ($this->group != null) {
            return $this->group->name;
        } else
            return "Federal";
    }

    public function getAgeAttribute()
    {
        $now = Carbon::now();

        //Calculate Age
        return Carbon::parse(date('Y-m-d', strtotime($this->dob)))->diffInYears($now);
    }

    public function getServiceAttribute()
    {
        $now = Carbon::now();

        //Calculate Service Years
        return Carbon::parse(date('Y-m-d', strtotime($this->doj)))->diffInYears($now);
    }

    public function getDefaultRank()
    {
        if ($this->Age < 12)
            return 'Junior Cadet';
        else if ($this->Age < 18)
            return 'Cadet';
        else
            return 'Officer';
    }

    public function getStatusAttribute()
    {
        switch ($this->type)
        {
            case 0:
                return 'Temporary';
            case 1:
                return 'League';
            case 2:
                return 'Associate';
            case 3:
                return 'Life';
            case 4:
                return 'Honorary';
            case 5:
                return 'Ex-Member';
            case 6:
                return 'Retired';
            case 7:
                return 'Deceased';
            case 8:
                return 'Leave';
            case 9:
                return 'Life Retired';
            case 10:
                return 'Adult Supporter';
        }
    }

    public function squadron()
    {
        return $this->hasOne(Squadron::class, 'id', 'squadron_id');
    }

    public function wing()
    {
        return $this->hasOne(Wing::class, 'id', 'wing_id');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function attendance()
    {
        return $this->hasMany(MemberAttendance::class, 'member_id', 'id');
    }
}
