<?php

namespace BamboleeDigital\OnboardingPackage\Services;

use BamboleeDigital\OnboardingPackage\Models\Question;
use BamboleeDigital\OnboardingPackage\Models\NavigationRule;

class NavigationService
{
    public function getNextQuestion($currentQuestionId, $response)
    {
        // Lógica para determinar a próxima pergunta com base nas regras de navegação
        $rule = NavigationRule::where('from_question_id', $currentQuestionId)
            ->where('response', $response)
            ->first();

        if ($rule) {
            return Question::find($rule->to_question_id);
        }

        // Se nenhuma regra for encontrada, retornar a próxima pergunta sequencial
        return Question::where('id', '>', $currentQuestionId)->first();
    }
}
