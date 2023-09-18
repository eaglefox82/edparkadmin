<?php

namespace App\Models\RecreationCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecreationCampRoomInspection extends Model
{
    use HasFactory;

    public function room()
    {
        return $this->hasOne(RecreationCampRoom::class, 'id', 'room_id');
    }
}
