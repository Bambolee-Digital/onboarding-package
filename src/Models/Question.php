<?php

namespace BamboleeDigital\OnboardingPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasTranslations;

    protected $fillable = ['text', 'type'];

    public $translatable = ['text'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function navigationRules()
    {
        return $this->hasMany(NavigationRule::class, 'from_question_id');
    }

    public function conditionalMessages()
    {
        return $this->hasMany(ConditionalMessage::class);
    }

}
