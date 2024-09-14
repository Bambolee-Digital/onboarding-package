<?php

namespace BamboleeDigital\OnboardingPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ConditionalMessage extends Model
{
    use HasTranslations;

    protected $fillable = ['message', 'conditions', 'priority', 'question_id'];

    public $translatable = ['message'];

    protected $casts = [
        'conditions' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
