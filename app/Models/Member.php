<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function MemberRank()
    {
        return $this->hasOne('App\Models\RankMapping', 'id', 'rank');
    }

    public function roll()
    {
        return $this->hasMany('App\Models\Roll');
    }

    public function eventroll()
    {
        return $this->hasMany('App\Models\Eventroll');
    }

    public function outstanding()
    {
        return $this->roll()->where('status', '=', 'P');
    }

    public function rollstatus()
    {
        $rollid = Rollmapping::latest()->value('id');
        return $this->hasOne('App\Models\Roll')
                ->where('roll_id', '=', $rollid)
                ->join('rollstatus', 'rollstatus.status_id', '=', 'roll.status')
                ->select('rollstatus.status as rstatus', 'roll.id as rollid');
    }

    public function requests()
    {
        return $this->hasMany('App\Models\Srequest');
    }

    public function currentrequests()
    {
        return $this->requests()->where('complete', '=', 'N');
    }

    public function accounts()
    {
        return $this->hasmany('App\Models\Accounts', 'member_id', 'id')
                 ->orderby('id', 'DESC');
    }

    public function flightmap()
    {
        return $this->hasOne('App\Models\Flight','id', 'flight' );
    }

    public function books()
    {
        return $this->hasMany('App\Models\MemberBook', 'memberID', 'id');
    }

    protected $with = array('accounts');


    public function getBirthdayAttribute()
    {
        $birthday = Carbon::parse($this->date_birth);

        $birthday->year(date('Y'));

        $birthday = Carbon::now()->diffInDays($birthday, false) +1;

            if ($birthday < 0) {
                $birthday = Carbon::parse($this->date_birth);

                $birthday->year(date('Y'))->addyear();

                $birthday = Carbon::now()->diffInDays($birthday, false) +1;
            }

        return $birthday;
    }

    public function getAnnualsubsAttribute()
    {
        $subs =Carbon::parse($this->date_joined);
        $date = Carbon::now();
        $yearstart = $date->copy()->startOfYear();

        $due = 'N';

        if($subs < $yearstart ) {
            $due = 'Y';
        }

        return $due;

    }

    public function pointslink()
    {
        return $this->hasMany('App\Models\Points', 'member_id', 'id');
    }

    public function points()
    {
        $year = Carbon::now()->year;
        return $this->pointslink()->where('year', $year);
    }

    public function rolllink()
    {
        return $this->hasMany('App\Models\Roll', 'member_id', 'id');
    }

    public function eventrolls()
    {
        return $this->hasMany('App\Models\Eventroll', 'member_id', 'id');
    }

    public function attendance()
    {
        $year = Carbon::now()->year;
        return $this->rolllink()->wherehas('rollmapping', function ($query){
            $query->whereYear('roll_date', now()->year);
        })
        ->where('status','!=', 'A');
    }

    public function event()
    {
        return $this->eventrolls()->wherehas('event', function ($query){
            $query->where('year', Carbon::now()->year);
        })
        ->where('status', '=', 'Y');
    }

    public function memberyear()
    {
        $year = Carbon::now()->year;
        return $this->rolllink()->wherehas('rollmapping', function ($query){
            $query->whereYear('roll_date', now()->year);
        });
    }

    public function eventyear()
    {
        return $this->eventrolls()->wherehas('event', function ($query){
            $query->where('year', Carbon::now()->year);
        });
    }

    public function getPointrankAttribute(){
        $year = Carbon::parse(Carbon::now())->year;

        $pointrank = Points::query()
            ->select('member_id')->selectRaw('SUM(value) as TotalPoints')
            ->where('Year','=', $year)
            ->groupBy('member_id')
            ->orderbyDesc('TotalPoints')
            ->get();

        return $pointrank->search(function($points){
            return $points->member_id == $this->id;
        }) + 1;

        return $pointrank;

    }

    public function getattendancewarningAttribute()
    {
       $week1 = Rollmapping::latest()->take(0)->value('id');
       $week2 = Rollmapping::latest()->skip(1)->take(1)->value('id');
       $week3 = Rollmapping::latest()->skip(2)->take(1)->value('id');

        $warning = 0;

       $week1a = Roll::where('Roll_id',$week1)->where('member_id', $this->id)->value('status');

       if ($week1a == 'A')
       {
           $warning = $warning + 1;
       }

       $week2a = Roll::where('Roll_id',$week2)->where('member_id', $this->id)->value('status');

       if ($week2a == 'A')
       {
           $warning = $warning + 1;
       }

       $week3a = Roll::where('Roll_id',$week3)->where('member_id', $this->id)->value('status');

       if ($week3a == 'A')
       {
           $warning = $warning + 1;
       }

       return $warning;

    }


}


