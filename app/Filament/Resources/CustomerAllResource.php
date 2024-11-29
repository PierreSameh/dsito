<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerAllResource\Pages;
use App\Filament\Resources\CustomerAllResource\RelationManagers;
use App\Filament\Resources\CustomerAllResource\RelationManagers\FavoritesRelationManager;
use App\Filament\Resources\CustomerAllResource\RelationManagers\PlaceOrdersRelationManager;
use App\Filament\Resources\CustomerAllResource\RelationManagers\WalletRelationManager;
use App\Models\Customer;
use App\Models\CustomerAll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerAllResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getLabel(): ?string
    {
        return __('Customer');  // Translation function works here
    }
    public static function getPluralLabel(): ?string
    {
        return __('Customers');  // For plural label translations
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('last_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->required(),
                Forms\Components\TextInput::make('full_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('customer_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                ->label(('Name'))
                ->formatStateUsing(function ($record){
                    return $record->first_name . " " . $record->last_name;
                })
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('user', function (Builder $query) use ($search): Builder {
                        return $query->where('first_name', 'like', "%{$search}%")
                                     ->orWhere('last_name', 'like', "%{$search}%");
                    });
                }),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PlaceOrdersRelationManager::class,
            WalletRelationManager::class,
            FavoritesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerAlls::route('/'),
            'create' => Pages\CreateCustomerAll::route('/create'),
            'view' => Pages\ViewCustomerAll::route('/{record}'),
        ];
    }
}
