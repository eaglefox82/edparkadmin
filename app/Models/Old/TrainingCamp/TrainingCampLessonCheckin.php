<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampLessonCheckin extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function lesson_allocation()
    {
        return $this->hasOne(TrainingCampLessonAllocation::class, 'id', 'lesson_allocation_id');
    }

    public function member()
    {
        return $this->hasOne(TrainingCampMember::class, 'id', 'member_id');
    }
}
