<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampLessonAllocation extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function schedule()
    {
        return $this->hasOne(TrainingCampSchedule::class, 'id', 'schedule_id');
    }

    public function classroom()
    {
        return $this->hasOne(TrainingCampClassroom::class, 'id', 'classroom_id');
    }

    public function flight()
    {
        return $this->hasOne(TrainingCampFlight::class, 'id', 'flight_id');
    }

    public function lesson()
    {
         return $this->hasOne(TrainingCampLesson::class, 'id', 'lesson_id');
    }

    public function checkins()
    {
        return $this->hasMany(TrainingCampLessonCheckin::class, 'lesson_allocation_id', 'id');
    }
}
