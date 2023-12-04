<?php

namespace App\Models\RecreationCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecreationCampEvent extends Model
{
    use HasFactory;

    public $moduleName = 'RecreationCamp';
    public $permissionName = 'Recreation Camps';

    public function rooms()
    {
        return $this->hasMany(RecreationCampRoom::class, 'event_id', 'id')->orderBy('room_number');
    }

    public function members()
    {
        return $this->hasMany(RecreationCampMember::class, 'event_id', 'id');
    }

    public function teams()
    {
        return $this->hasMany(RecreationCampTeam::class, 'event_id', 'id')->orderBy('name');
    }

    public function accountTransactions()
    {
        return $this->hasMany(RecreationCampAccountTransaction::class, 'event_id', 'id');
    }

    public function medicalMembers()
    {
        return $this->hasMany(RecreationCampMember::class, 'event_id', 'id')->whereHas('member', function ($q){
            $q->where('medical_requirements', '<>', '');
        });
    }

    public function dietaryMembers()
    {
        return $this->hasMany(RecreationCampMember::class, 'event_id', 'id')->whereHas('member', function ($q){
            $q->where('dietary_requirements', '<>', '');
        });
    }
}
