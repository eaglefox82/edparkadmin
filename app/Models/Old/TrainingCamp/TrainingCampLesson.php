<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampLesson extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function allocations()
    {
        return $this->hasMany(TrainingCampLessonAllocation::class, 'lesson_id', 'id');
    }
}
