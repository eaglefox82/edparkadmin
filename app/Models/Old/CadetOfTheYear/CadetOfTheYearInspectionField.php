<?php

namespace App\Models\CadetOfTheYear;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadetOfTheYearInspectionField extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(CadetOfTheYearEvent::class, 'id', 'event_id');
    }

    public function averagePoints()
    {
        return $this->hasMany(CadetOfTheYearInspectionResult::class, 'field_id', 'id')
            ->avg('points_lost');
    }
}
