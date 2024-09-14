<?php

namespace BamboleeDigital\OnboardingPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Option extends Model
{
    use HasTranslations;

    protected $fillable = ['question_id', 'text', 'sort', 'message'];

    public $translatable = ['text', 'message'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function nextQuestion()
    {
        return $this->belongsTo(Question::class, 'next_question_id');
    }

}
