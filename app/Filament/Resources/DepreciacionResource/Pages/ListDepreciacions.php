<?php

namespace App\Filament\Resources\DepreciacionResource\Pages;

use App\Filament\Resources\DepreciacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepreciacions extends ListRecords
{
    protected static string $resource = DepreciacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
