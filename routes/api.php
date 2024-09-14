<?php

use Illuminate\Support\Facades\Route;
use BamboleeDigital\OnboardingPackage\Http\Controllers\ResponseController;
use BamboleeDigital\OnboardingPackage\Http\Controllers\API\QuestionController;

Route::prefix(config('onboarding.route_prefix'))
    ->middleware(config('onboarding.middleware'))
    ->group(function () {
        Route::get('/questions', [QuestionController::class, 'index']);
        Route::post('/onboarding/responses', [ResponseController::class, 'store']);
        Route::get('/onboarding/user-responses', [ResponseController::class, 'getUserResponses']);
});
