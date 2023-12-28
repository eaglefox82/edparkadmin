<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'group_id', 'id');
    }

    public function wings()
    {
        return $this->hasMany(Wing::class, 'group_id', 'id');
    }
}
