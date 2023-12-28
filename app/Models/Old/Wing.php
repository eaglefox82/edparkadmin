<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'group_id', 'active'
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'wing_id', 'id');
    }

    public function squadrons()
    {
        return $this->hasMany(Squadron::class, 'wing_id', 'id');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function roll_strength()
    {
        $rollStrength = 0;
        foreach ($this->squadrons as $sqn) {
            $rollStrength += $sqn->roll_strength();
        }
        return $rollStrength + $this->members()->whereIn('type', [1, 3])->count();
    }
}
