<?php

namespace BamboleeDigital\OnboardingPackage\Services;

use BamboleeDigital\OnboardingPackage\Models\UserResponse;
use BamboleeDigital\OnboardingPackage\Models\ConditionalMessage;

class MessageService
{
    public function getConditionalMessage($userId = null)
    {
        // Recuperar todas as respostas do usuário
        $responses = UserResponse::where('user_id', $userId)->pluck('response', 'question_id')->toArray();

        $messages = ConditionalMessage::orderBy('priority', 'desc')->get();

        foreach ($messages as $message) {
            $conditionsMet = true;
            foreach ($message->conditions as $questionId => $expectedResponses) {
                $expectedResponsesArray = is_array($expectedResponses) ? $expectedResponses : [$expectedResponses];
                $userResponse = $responses[$questionId] ?? null;
                if (!in_array($userResponse, $expectedResponsesArray)) {
                    $conditionsMet = false;
                    break;
                }
            }
            if ($conditionsMet) {
                return $message;
            }
        }

        return null;
    }
}
