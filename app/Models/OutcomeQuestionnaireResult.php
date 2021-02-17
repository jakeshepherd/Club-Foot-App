<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomeQuestionnaireResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'questionnaire_id',
        'questionnaire_data',
    ];

    protected $casts = [
        'questionnaire_data' => 'array',
    ];
}
