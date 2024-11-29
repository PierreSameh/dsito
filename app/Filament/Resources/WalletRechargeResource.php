<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletRechargeResource\Pages;
use App\Filament\Resources\WalletRechargeResource\RelationManagers;
use App\Models\WalletRecharge;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;

class WalletRechargeResource extends Resource
{
    protected static ?string $model = WalletRecharge::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')->disabled(),
                TextInput::make('phone_number')->disabled(),
                TextInput::make('status')->disabled()
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                ->label('Photo')
                ->url(fn($record) => asset($record->photo)), // Make image clickable
                Tables\Columns\TextColumn::make('wallet.customer.username'),
                Tables\Columns\TextColumn::make('phone_number')->label('Phone Number'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('accept')
                    ->label('Accept')
                    ->modalHeading('Accept Recharge')
                    ->modalSubheading('Enter the amount to add to the wallet.')
                    ->modalButton('Add Amount')
                    ->form([
                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->label('Amount'),
                    ])
                    ->action(function ($record, array $data) {
                        $wallet = $record->wallet;
                        $wallet->balance += $data['amount'];
                        $wallet->save();

                        $record->status = 'accepted';
                        $record->save();
                    })
                    ->visible(
                        fn($record) => $record->status === 'pending'
                    ),

                    Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->modalHeading('Reject Recharge')
                    ->modalSubheading('Provide a reason for rejecting this recharge.')
                    ->modalButton('Submit')
                    ->form([
                        Forms\Components\Textarea::make('reject_reason')
                            ->required()
                            ->label('Rejection Reason'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->status = 'rejected';
                        $record->reject_reason = $data['reject_reason'];
                        $record->save();
                    })
                    ->visible(
                        fn($record) => $record->status === 'pending'
                    ),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListWalletRecharges::route('/'),
            'create' => Pages\CreateWalletRecharge::route('/create'),
            'edit' => Pages\EditWalletRecharge::route('/{record}/edit'),
        ];
    }
}
