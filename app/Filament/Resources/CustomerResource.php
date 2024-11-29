<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Resources\CustomerResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers\WalletRelationManager;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'المندوبون';
    protected static ?string $pluralModelLabel = 'المندوبون';
    protected static ?string $modelLabel = 'مندوب';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('picture')
                    ->default(null),
                Forms\Components\TextInput::make('full_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('delivery_rate')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('national_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('id_front')
                    ->default(null),
                Forms\Components\FileUpload::make('id_back')
                    ->default(null),
                Forms\Components\FileUpload::make('selfie')
                    ->default(null),
                Forms\Components\Select::make('delivery_status')
                    ->options([
                        'undefined' => 'غير محدد',
                        'waiting' => 'في انتظار الموافقة',
                        'approved' => 'مقبول',
                        'hold' => 'موقوف',
                        'block' => 'محظور',
                    ])
                    ->required()
                    ->label('حالة المندوب'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('delivery', 1))
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivery_status'),
                Tables\Columns\TextColumn::make('national_id')
                    ->searchable(),
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
                Tables\Actions\Action::make('approve')
                    ->label('قبول')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn(Customer $record) => $record->update(['delivery_status' => 'approved']))
                    ->visible(
                        fn($record) => $record->delivery_status != 'approved'
                    ),
                    Tables\Actions\Action::make('block')
                    ->label('حظر')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn(Customer $record) => $record->update(['delivery_status' => 'block']))
                    ->visible(
                        fn($record) => $record->delivery_status != 'block'
                    ),
                    Tables\Actions\Action::make('hold')
                    ->label('إيقاف مؤقت')
                    ->color('warning')
                    ->icon('heroicon-o-exclamation-circle')
                    ->action(fn(Customer $record) => $record->update(['delivery_status' => 'hold']))
                    ->visible(
                        fn($record) => $record->delivery_status != 'hold'
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrdersRelationManager::class,
            WalletRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
        ];
    }
}
