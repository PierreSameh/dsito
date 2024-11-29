<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\CancelRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['placeOrder.customer', 'delivery']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('EGP'),
                Forms\Components\TextInput::make('rate_delivery'),
                Forms\Components\TextInput::make('rate_customer'),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\DateTimePicker::make('delivery_time'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('placeOrder.customer.full_name')
                    ->label('Orderd By')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery.full_name')
                    ->numeric()
                    ->label('Delivery By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('rate_delivery')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('rate_customer')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('placeOrder.payment_method'),
                Tables\Columns\TextColumn::make('placeOrder.paid')
                ->badge()
                ->color(fn ( $state): string => $state ? 'success' : 'danger')
                ->formatStateUsing(
                    fn ( $record): string => $record->placeOrder->paid ? 'Paid' : 'Not Paid'
                )
                ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(('Order Status'))
                    ->formatStateUsing(function ($record) {

                        switch ($record->status) {
                            case 'waiting':
                                return __('Waiting');
                            case 'first_point':
                                return __('First point');
                            case 'received':
                                return __('Received');
                            case 'sec_point':
                                return __('Second point');
                            case 'completed':
                                return __('Completed');
                            case 'cancelled_user':
                                return __('Cancelled by user');
                            case 'cancelled_delivery':
                                return __('Cancelled by delivery');
                            default:
                                return __('Unknown Status');
                    }
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivery_time')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('cancelled_user')
                ->label('إيقاف كمستخدم')
                ->color('danger')
                ->action(fn(Order $record) => $record->update(['status' => 'cancelled_user'])),
                Tables\Actions\Action::make('cancelled_delivery')
                ->label('إيقاف كمندوب')
                ->color('danger')
                ->action(fn(Order $record) => $record->update(['status' => 'cancelled_delivery'])),
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
            CancelRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
