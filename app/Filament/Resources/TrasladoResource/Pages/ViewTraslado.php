<?php

namespace App\Filament\Resources\TrasladoResource\Pages;

use App\Filament\Resources\TrasladoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTraslado extends ViewRecord
{
    protected static string $resource = TrasladoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
