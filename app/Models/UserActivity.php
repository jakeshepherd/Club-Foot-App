<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'user_activity';

    protected $fillable = [
        'user_id',
        'activity_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
