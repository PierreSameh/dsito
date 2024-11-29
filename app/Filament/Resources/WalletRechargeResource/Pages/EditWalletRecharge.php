<?php

namespace App\Filament\Resources\WalletRechargeResource\Pages;

use App\Filament\Resources\WalletRechargeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWalletRecharge extends EditRecord
{
    protected static string $resource = WalletRechargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
