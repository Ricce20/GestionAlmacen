<?php

namespace App\Filament\Resources\AsignacionResource\Pages;

use App\Filament\Resources\AsignacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
class ListAsignacions extends ListRecords
{
    protected static string $resource = AsignacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->hidden(fn():bool => in_array(auth()->user()->rol, ['Empleado', 'Director','Coordinador'])),
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
            'Inactivos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('activo', false)),
            'Activos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('activo', true)),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'Activos';
    }
}
