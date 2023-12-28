<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampInspectionField extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function averagePoints()
    {
        return $this->hasMany(TrainingCampInspectionResult::class, 'field_id', 'id')->avg('points_lost');
    }
}
