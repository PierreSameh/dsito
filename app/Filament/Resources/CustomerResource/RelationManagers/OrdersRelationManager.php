<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models\Order;
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
                    ->numeric()
                    ->prefix('EGP'),
                Forms\Components\TextInput::make('rate_delivery'),
                Forms\Components\TextInput::make('rate_customer'),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\DateTimePicker::make('delivery_time'),
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
                Tables\Columns\TextColumn::make('id')
                    ->label('Order Number')
                    ->numeric()
                    ->sortable(),
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
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn(Order $record) => ( '/admin/orders/' . $record->id))
                    ->openUrlInNewTab(false), // Ensure it doesn't open in a new tab
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
}
