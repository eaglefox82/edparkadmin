<?php

namespace App\Models\RecreationCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecreationCampRoom extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->hasMany(RecreationCampMember::class, 'room_id', 'id')
            ->get()
            ->sortBy(function ($registration) {
                return $registration->member->last_name.'.'.$registration->member->first_name;
            });
    }

    public function inspections()
    {
        return $this->hasMany(RecreationCampRoomInspection::class, 'room_id', 'id');
    }
}
