<?php

namespace BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;
use BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource;

class CreateQuestion extends CreateRecord
{
    use Translatable;

    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
