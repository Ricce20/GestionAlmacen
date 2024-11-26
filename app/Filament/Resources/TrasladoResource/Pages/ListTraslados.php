<?php

namespace App\Filament\Resources\TrasladoResource\Pages;

use App\Filament\Resources\TrasladoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
class ListTraslados extends ListRecords
{
    protected static string $resource = TrasladoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            // 'Finalizados' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('fecha_finalizacion', '!=', null)),
            // 'Sin Finalizar' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('fecha_finalizacion', null)),
            'Pendientes' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('fecha_cierre', null)),
                
            'Rechazados' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('aceptado', false)),
            'Aceptados' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('aceptado', true)),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'Pendientes';
    }
}
