<?php

namespace BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\Pages;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\Translatable;
use BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource;

class EditQuestion extends EditRecord
{
    use Translatable;

    protected static string $resource = QuestionResource::class;

    // Remova a propriedade reativa
    // #[Reactive]
    // public ?string $activeLocale = null;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
