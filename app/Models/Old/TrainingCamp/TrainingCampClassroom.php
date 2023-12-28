<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampClassroom extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function allocations()
    {
        return $this->hasMany(TrainingCampLessonAllocation::class, 'room_id', 'id');
    }
}
