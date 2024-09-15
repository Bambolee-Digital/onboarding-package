<?php

namespace BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Actions;
use Livewire\Attributes\Reactive;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use BamboleeDigital\OnboardingPackage\Models\Question;
use Filament\Resources\RelationManagers\RelationManager;
use BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\RelationManagers\Concerns\Translatable;

class OptionsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'options';

    protected static ?string $recordTitleAttribute = 'text';

    #[Reactive]
    public ?string $activeLocale = null;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'pt']; // Defina os idiomas que deseja suportar
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
           Grid::make(1)->schema([
                TextInput::make('text')
                    ->label('Text')
                    ->required(),
                MarkdownEditor::make('description')
                    ->label('Description')
                    ->required(false),
                Select::make('next_question_id')
                    ->label('Next Question')
                    ->options(Question::all()->pluck('text', 'id'))
                    ->searchable()
                    ->nullable(),
            ]),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('text')
                    ->label('Text')
                    ->getStateUsing(fn ($record) => $record->getTranslation('text', $this->activeLocale))
                    ->sortable()
                    ->searchable(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
                Tables\Actions\LocaleSwitcher::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
