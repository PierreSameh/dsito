<?php

namespace App\Filament\Resources\CustomerAllResource\RelationManagers;

use App\Models\Order;
use App\Models\PlaceOrder;
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
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('order'))
            ->columns([
                Tables\Columns\TextColumn::make('order.id')
                    ->label('Order Number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label('Orderd By')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.delivery.full_name')
                    ->numeric()
                    ->label('Delivery By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.price')
                    ->money()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('rate_delivery')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('rate_customer')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('payment_method'),
                Tables\Columns\TextColumn::make('paid')
                ->badge()
                ->color(fn ( $state): string => $state ? 'success' : 'danger')
                ->formatStateUsing(
                    fn ( $record): string => $record->paid ? 'Paid' : 'Not Paid'
                )
                ->sortable(),
                Tables\Columns\TextColumn::make('order.status')
                    ->label(('Order Status'))
                    ->formatStateUsing(function ($record) {

                        switch ($record->order->status) {
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
                Tables\Columns\TextColumn::make('order.delivery_time')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.created_at')
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
                    ->url(fn(PlaceOrder $record) => ( '/admin/orders/' . $record->order->id))
                    ->openUrlInNewTab(false), // Ensure it doesn't open in a new tab
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
