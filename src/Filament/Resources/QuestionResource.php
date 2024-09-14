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

    protected static ?string $navigationLabel = 'Perguntas';

    protected static ?string $pluralModelLabel = 'Perguntas';

    protected static ?string $modelLabel = 'Pergunta';

    public static function getTranslatableLocales(): array
    {
        return ['en', 'pt']; // Defina os idiomas que deseja suportar
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('text')
                ->label('Texto da Pergunta')
                ->required(),
            Select::make('type')
                ->label('Tipo de Pergunta')
                ->options([
                    'text' => 'Texto',
                    'single_choice' => 'Escolha Única',
                    'multiple_choice' => 'Escolha Múltipla',
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
                    ->label('Texto')
                    ->getStateUsing(fn ($record) => $record->getTranslation('text', app()->getLocale()))
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipo')
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
