<?php

namespace App\Models\RecreationCamp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecreationCampTeam extends Model
{
    use HasFactory;

    public function allMembers()
    {
        return $this->hasMany(RecreationCampMember::class, 'team_id', 'id');
    }

    public function members()
    {
        return $this->hasMany(RecreationCampMember::class, 'team_id', 'id')
            ->get()
            ->sortBy(function ($registration) {
                return $registration->member->last_name.'.'.$registration->member->first_name;
            });
    }
}
