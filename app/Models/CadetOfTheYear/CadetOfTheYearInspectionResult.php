<?php

namespace App\Models\CadetOfTheYear;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadetOfTheYearInspectionResult extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->hasOne(CadetOfTheYearParticipant::class, 'id', 'member_id');
    }

    public function field()
    {
        return $this->hasOne(CadetOfTheYearInspectionField::class, 'id', 'field_id');
    }
}
