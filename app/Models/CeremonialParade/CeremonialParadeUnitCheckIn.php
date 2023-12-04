<?php

namespace App\Models\CeremonialParade;

use App\Models\Squadron;
use App\Models\Wing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeremonialParadeUnitCheckIn extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(CeremonialParadeEvent::class, 'id', 'event_id');
    }

    public function unitName()
    {
        $squadron = $this->hasOne(Squadron::class, 'id', 'squadron_id')->first();
        if ($squadron != null) {
            return $squadron->name;
        }

        $wing = $this->hasOne(Wing::class, 'id', 'wing_id')->first();
        if ($wing != null) {
            return $wing->name;
        }

        return 'UNKNOWN';
    }

    public function squadron()
    {
        return $this->hasOne(Squadron::class, 'id', 'squadron_id');
    }

    public function wing()
    {
        return $this->hasOne(Wing::class, 'id', 'wing_id');
    }
}
