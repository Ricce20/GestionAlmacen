<?php

namespace App\Filament\Resources\ObjetoGastoResource\Pages;

use App\Filament\Resources\ObjetoGastoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObjetoGasto extends EditRecord
{
    protected static string $resource = ObjetoGastoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
