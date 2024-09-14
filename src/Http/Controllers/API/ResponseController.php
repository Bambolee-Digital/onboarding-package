<?php

namespace BamboleeDigital\OnboardingPackage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use BamboleeDigital\OnboardingPackage\Models\Option;
use BamboleeDigital\OnboardingPackage\Models\Question;
use BamboleeDigital\OnboardingPackage\Models\UserResponse;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $data = $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'response_id' => 'nullable|integer|exists:options,id',
            'response' => 'nullable|string'
        ]);

        // Salvar a resposta do usuário
        $userResponse = UserResponse::create([
            'user_id' => $userId,
            'question_id' => $data['question_id'],
            'response_id' => $data['response_id'] ?? null,
            'response' => $data['response'] ?? null,
        ]);

        if (!$userResponse) {
            return response()->json(['error' => 'Erro ao salvar a resposta'], 500);
        }

        $conditionalMessage = null;
        $nextQuestion = null;

        if (!empty($data['response_id'])) {
            $option = Option::find($data['response_id']);

            // Verificar se há uma mensagem condicional
            if ($option && $option->message) {
                $conditionalMessage = [
                    'message' => $option->getTranslation('message', app()->getLocale()),
                ];
            }

            // Obter a próxima pergunta definida na opção
            if ($option && $option->next_question_id) {
                $nextQuestion = Question::find($option->next_question_id);
            }
        }

        // Se não houver próxima pergunta definida na opção, obter a próxima pergunta padrão
        if (!$nextQuestion) {
            $nextQuestion = $this->getNextQuestion($data['question_id']);
        }

        return response()->json([
            'next_question' => $nextQuestion ? $nextQuestion->toArray() : null,
            'conditional_message' => $conditionalMessage,
        ]);
    }

    public function getUserResponses(Request $request)
    {
        // Certifique-se de que o usuário esteja autenticado
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $responses = UserResponse::with(['question', 'option'])
            ->where('user_id', $userId)
            ->get();

        // Formatar as respostas
        $formattedResponses = $responses->map(function ($response) {
            return [
                'question_id' => $response->question_id,
                'question_text' => $response->question->getTranslation('text', app()->getLocale()),
                'response' => $response->response,
                'response_id' => $response->response_id,
                'option_text' => $response->option ? $response->option->getTranslation('text', app()->getLocale()) : null,
            ];
        });

        return response()->json([
            'responses' => $formattedResponses,
        ]);
    }



    private function getNextQuestion($currentQuestionId)
    {
        // Obter a próxima pergunta com base na ordem de criação
        return Question::where('id', '>', $currentQuestionId)->orderBy('id')->first();
    }
}
