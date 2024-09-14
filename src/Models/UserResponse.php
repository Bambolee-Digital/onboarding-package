<?php

namespace BamboleeDigital\OnboardingPackage\Models;

use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    protected $fillable = ['user_id', 'question_id', 'response_id', 'response'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class, 'response_id');
    }
}
