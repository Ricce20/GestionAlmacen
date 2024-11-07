<?php

namespace App\Filament\Resources\AcquisitionTypeResource\Pages;

use App\Filament\Resources\AcquisitionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAcquisitionTypes extends ManageRecords
{
    protected static string $resource = AcquisitionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
