<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampMealCheckin extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function meal()
    {
        return $this->hasOne(TrainingCampMeal::class, 'id', 'meal_id');
    }

    public function member()
    {
        return $this->hasOne(TrainingCampMember::class, 'id', 'member_id');
    }
}
