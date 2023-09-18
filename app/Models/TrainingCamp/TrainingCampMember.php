<?php

namespace App\Models\TrainingCamp;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampMember extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function room()
    {
        return $this->hasOne(TrainingCampRoom::class, 'id', 'room_id');
    }

    public function flight()
    {
        return $this->hasOne(TrainingCampFlight::class, 'id', 'flight_id');
    }

    public function lesson_checkins()
    {
        return $this->hasMany(TrainingCampLessonCheckin::class, 'member_id', 'id');
    }

    public function meal_checkins()
    {
        return $this->hasMany(TrainingCampMealCheckin::class, 'member_id', 'id');
    }

    public function inspection_results()
    {
        return $this->hasMany(TrainingCampInspectionResult::class, 'member_id', 'id');
    }
}
