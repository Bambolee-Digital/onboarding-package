<?php

namespace BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\RelationManagers\Concerns;

use  Filament\Resources\RelationManagers\Concerns\Translatable as BaseTranslatable;

trait Translatable
{
    use BaseTranslatable;

    public ?string $activeLocale = null;

    public function mountTranslatable(): void
    {
        $this->activeLocale = $this->getDefaultTranslatableLocale();
    }

    public function getTranslatableLocales(): array
    {
        return static::getResource()::getTranslatableLocales();
    }

    public function updatedActiveLocale($locale): void
    {
        // Atualiza o formulário e a tabela quando o idioma ativo mudar
        $this->form->fill();
        $this->table->refresh();
    }
}
