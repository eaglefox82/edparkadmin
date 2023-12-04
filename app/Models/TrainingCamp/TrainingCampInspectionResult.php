<?php

namespace App\Models\TrainingCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCampInspectionResult extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(TrainingCampEvent::class, 'id', 'event_id');
    }

    public function field()
    {
        return $this->hasOne(TrainingCampInspectionField::class, 'id', 'field_id');
    }

    public function member()
    {
        return $this->hasOne(TrainingCampMember::class, 'id', 'member_id');
    }
}
