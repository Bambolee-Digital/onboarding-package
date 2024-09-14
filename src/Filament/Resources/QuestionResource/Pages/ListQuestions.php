<?php

namespace BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource;

class ListQuestions extends ListRecords
{
    use Translatable;

    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
