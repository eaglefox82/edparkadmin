<?php

namespace App\Models\CadetOfTheYear;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadetOfTheYearEvent extends Model
{
    use HasFactory;

    public $moduleName = 'CadetOfTheYear';
    public $permissionName = 'Cadet Of The Year';

    public function members()
    {
        return $this->hasMany(CadetOfTheYearParticipant::class, 'event_id', 'id');
    }

    public function inspection_fields()
    {
        return $this->hasMany(CadetOfTheYearInspectionField::class, 'event_id', 'id')
            ->orderBy('display_order');
    }
}
