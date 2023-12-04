<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Squadron extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'roll_strength', 'wing_id', 'active'
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'squadron_id', 'id');
    }

    public function wing()
    {
        return $this->hasOne(Wing::class, 'id', 'wing_id');
    }

    public function roll_strength()
    {
        return $this->members()->whereIn('type', [1, 3])->count();
    }
}
