<?php

namespace App\Filament\Resources\ObjetoGastoResource\Pages;

use App\Filament\Resources\ObjetoGastoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListObjetoGastos extends ListRecords
{
    protected static string $resource = ObjetoGastoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
