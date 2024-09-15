<?php

namespace BamboleeDigital\OnboardingPackage\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Concerns\Translatable;
use Filament\Forms;
use Filament\Tables;
use BamboleeDigital\OnboardingPackage\Models\Question;
use BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\Pages;
use BamboleeDigital\OnboardingPackage\Filament\Resources\QuestionResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;

class QuestionResource extends Resource
{
    use Translatable;

    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Questions';

    protected static ?string $pluralModelLabel = 'Questions';

    protected static ?string $modelLabel = 'Question';

    public static function getTranslatableLocales(): array
    {
        return config('onboarding.locales', ['en', 'es', 'pt']);
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('text')
                ->label('Question Text')
                ->required(),
            Select::make('type')
                ->label('Question Type')
                ->options([
                    'text' => 'Text',
                    'single_choice' => 'Single Choice',
                    'multiple_choice' => 'Multiple Choice',
                ])
                ->required(),
            // Remova o Repeater de options, pois agora usamos o RelationManager
            // Repeater::make('options')->...
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('text')
                    ->label('Question Text')
                    ->getStateUsing(fn ($record) => $record->getTranslation('text', app()->getLocale()))
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Question Type')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\ViewAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OptionsRelationManager::class,
            // Adicione outros RelationManagers se necessário
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
