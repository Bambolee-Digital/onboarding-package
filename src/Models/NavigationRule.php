<?php

namespace BamboleeDigital\OnboardingPackage\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationRule extends Model
{
    protected $fillable = ['from_question_id', 'to_question_id', 'response'];

    public function fromQuestion()
    {
        return $this->belongsTo(Question::class, 'from_question_id');
    }

    public function toQuestion()
    {
        return $this->belongsTo(Question::class, 'to_question_id');
    }
}
