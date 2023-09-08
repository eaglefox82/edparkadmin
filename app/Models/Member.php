<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'membership_number', 'first_name', 'last_name', 'rank', 'date_joined', 'date_birth', 'active'
    ];


}


