<?php

namespace BamboleeDigital\OnboardingPackage\Http\Controllers\API;


use Illuminate\Routing\Controller;
use BamboleeDigital\OnboardingPackage\Models\Question;
use BamboleeDigital\OnboardingPackage\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    public function index()
    {
        $firstQuestion = Question::first(); // Ajuste a lógica conforme necessário
        return new QuestionResource($firstQuestion->load('options'));
    }
}
