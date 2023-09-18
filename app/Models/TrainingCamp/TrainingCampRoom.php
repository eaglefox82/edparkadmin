<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampRoom extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function members()
    {
        return $this->hasMany(TrainingCampMember::class, 'room_id', 'id')
            ->get()
            ->sortBy(function ($registration) {
                return $registration->member->last_name.'.'.$registration->member->first_name;
            });
    }

    public function presentMembers()
    {
        return $this->hasMany(TrainingCampMember::class, 'room_id', 'id')
            ->where('camp_checkin', '<>', null)
            ->where('camp_checkout', null)
            ->get()
            ->sortBy(function ($registration) {
                return $registration->member->last_name.'.'.$registration->member->first_name;
            });
    }
}
