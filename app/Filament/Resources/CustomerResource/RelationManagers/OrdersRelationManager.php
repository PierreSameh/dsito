<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->maxLength(255),
            ]);
    }
    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('price')
            ->columns([
                Tables\Columns\TextColumn::make('placeOrder.customer.full_name')->label('Ordered by'),
                Tables\Columns\TextColumn::make('placeOrder.address_from')->label('Start Point'),
                Tables\Columns\TextColumn::make('placeOrder.address_to')->label('Distenation'),
                Tables\Columns\TextColumn::make('placeOrder.price'),
                Tables\Columns\TextColumn::make('placeOrder.payment_method'),
                Tables\Columns\TextColumn::make('placeOrder.paid'),
                Tables\Columns\TextColumn::make('placeOrder.status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
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
