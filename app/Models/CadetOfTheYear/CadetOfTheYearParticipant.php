<?php

namespace App\Models\CadetOfTheYear;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadetOfTheYearParticipant extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function event()
    {
        return $this->hasOne(CadetOfTheYearEvent::class, 'id', 'event_id');
    }

    public function inspection_results()
    {
        return $this->hasMany(CadetOfTheYearInspectionResult::class, 'member_id', 'id');
    }
}
