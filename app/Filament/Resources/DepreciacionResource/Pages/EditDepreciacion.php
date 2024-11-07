<?php

namespace App\Filament\Resources\DepreciacionResource\Pages;

use App\Filament\Resources\DepreciacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepreciacion extends EditRecord
{
    protected static string $resource = DepreciacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
