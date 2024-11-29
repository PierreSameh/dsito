<?php

namespace App\Filament\Resources\CustomerAllResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlaceOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'placeOrders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_from')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_to')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('details')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('price')
            ->columns([
                Tables\Columns\TextColumn::make('address_from'),
                Tables\Columns\TextColumn::make('address_to'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\ToggleColumn::make('paid'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
