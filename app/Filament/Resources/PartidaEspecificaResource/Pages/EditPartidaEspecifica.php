<?php

namespace App\Filament\Resources\PartidaEspecificaResource\Pages;

use App\Filament\Resources\PartidaEspecificaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartidaEspecifica extends EditRecord
{
    protected static string $resource = PartidaEspecificaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
