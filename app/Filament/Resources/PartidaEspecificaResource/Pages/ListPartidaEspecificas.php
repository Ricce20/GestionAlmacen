<?php

namespace App\Filament\Resources\PartidaEspecificaResource\Pages;

use App\Filament\Resources\PartidaEspecificaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Status;
class ListPartidaEspecificas extends ListRecords
{
    protected static string $resource = PartidaEspecificaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        // Obtiene todos los estados relevantes para activos
        $statuses = Status::where('para_partida', true)->get();

        // Inicializa el array de tabs con la opción "all"
        $tabs = ['all' => Tab::make()];

        // Agrega una tab para cada estado obtenido de la base de datos
        foreach ($statuses as $status) {
            $tabs[$status->status] = Tab::make()->modifyQueryUsing(
                fn (Builder $query) => $query->where('status_id', $status->id)
            );
        }

        return $tabs;
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'En proceso';
    }
}
