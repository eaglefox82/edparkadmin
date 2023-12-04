<?php

namespace App\Models\RecreationCamp;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecreationCampMember extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    public function event()
    {
        return $this->hasOne(RecreationCampEvent::class, 'id', 'event_id');
    }

    public function team()
    {
        return $this->hasOne(RecreationCampTeam::class, 'id', 'team_id');
    }

    public function room()
    {
        return $this->hasOne(RecreationCampRoom::class, 'id', 'room_id');
    }
}
