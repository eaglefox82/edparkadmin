<?php

namespace App\Models\CeremonialParade;

use App\Models\Wing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeremonialParadeEvent extends Model
{
    use HasFactory;

    public $moduleName = 'CeremonialParade';
    public $permissionName = 'Ceremonial Parades';

    public function squadrons()
    {
        return $this->hasMany(CeremonialParadeUnitCheckIn::class, 'event_id', 'id')->where('squadron_id', '<>', null);
    }

    public function wings()
    {
        return $this->hasMany(CeremonialParadeUnitCheckIn::class, 'event_id', 'id')->where('wing_id', '<>', null);
    }

    public function wingUnitAttendance(Wing $wing): int
    {
        $attendance = 0;

        foreach ($wing->squadrons as $sqn) {
            $rego = $this->squadrons()->where('squadron_id', $sqn->id)->first();
            if ($rego != null && $rego->checked_in != null) {
                $attendance += $rego->on_parade;
            }
        }

        return $attendance;
    }
}
