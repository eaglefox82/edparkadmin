<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampEvent extends Model
{
    use HasFactory;

    public $moduleName = 'TrainingCamp';
    public $permissionName = 'Training Camps';

    public function members()
    {
        return $this->hasMany(TrainingCampMember::class, 'event_id', 'id');
    }

    public function checkedInMembers()
    {
        return $this->hasMany(TrainingCampMember::class, 'event_id', 'id')
            ->where('camp_checkin', '<>', null)
            ->where('camp_checkout', null);
    }

    public function dayMembers()
    {
        return $this->hasMany(TrainingCampMember::class, 'event_id', 'id')
            ->where('day_visitor', true);
    }

    public function bandMembers()
    {
        return $this->hasMany(TrainingCampMember::class, 'event_id', 'id')
            ->where('band_training', true);
    }

    public function medicalMembers()
    {
        return $this->hasMany(TrainingCampMember::class, 'event_id', 'id')->whereHas('member', function ($q){
            $q->where('medical_requirements', '<>', '');
        });
    }

    public function dietaryMembers()
    {
        return $this->hasMany(TrainingCampMember::class, 'event_id', 'id')->whereHas('member', function ($q){
            $q->where('dietary_requirements', '<>', '');
        });
    }

    public function rooms()
    {
        return $this->hasMany(TrainingCampRoom::class, 'event_id', 'id')->orderBy('room_number');
    }

    public function flights()
    {
        return $this->hasMany(TrainingCampFlight::class, 'event_id', 'id')->orderBy('name');
    }

    public function classrooms()
    {
        return $this->hasMany(TrainingCampClassroom::class, 'event_id', 'id')->orderBy('name');
    }

    public function schedules()
    {
        return $this->hasMany(TrainingCampSchedule::class, 'event_id', 'id')->orderBy('start_time');
    }

    public function meals()
    {
        return $this->hasMany(TrainingCampMeal::class, 'event_id', 'id')->orderBy('start_time');
    }

    public function lessons()
    {
        return $this->hasMany(TrainingCampLesson::class, 'event_id', 'id')->orderBy('name');
    }

    public function inspection_fields()
    {
        return $this->hasMany(TrainingCampInspectionField::class, 'event_id', 'id')->orderBy('display_order');
    }
}
