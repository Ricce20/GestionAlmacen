<?php

namespace App\Filament\Resources\DepreciacionResource\Pages;

use App\Filament\Resources\DepreciacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDepreciacion extends ViewRecord
{
    protected static string $resource = DepreciacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
