<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MiscPagesResource\Pages;
use App\Filament\Resources\MiscPagesResource\RelationManagers;
use App\Models\MiscPages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\KeyValue;

class MiscPagesResource extends Resource
{
    protected static ?string $model = MiscPages::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 6;

    public static function getLabel(): ?string
    {
        return __('Page');  // Translation function works here
    }
    public static function getPluralLabel(): ?string
    {
        return __('Pages');  // For plural label translations
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('about')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('privacy_terms')
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('faq')
                    ->keyLabel('Question')
                    ->valueLabel('Answer')
                    ->helperText('From question you can add questions and their answers')
                    ->addButtonLabel('Add Question')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('contact_us')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('about')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('privacy_terms')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_us')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMiscPages::route('/'),
            'create' => Pages\CreateMiscPages::route('/create'),
            'view' => Pages\ViewMiscPages::route('/{record}'),
            'edit' => Pages\EditMiscPages::route('/{record}/edit'),
        ];
    }
}
