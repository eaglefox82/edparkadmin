<?php

namespace App\Models\RecreationCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecreationCampAccountTransaction extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->hasOne(RecreationCampEvent::class, 'id', 'event_id');
    }
}
