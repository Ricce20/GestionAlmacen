<?php

namespace App\Filament\Resources\TrasladoResource\Pages;

use App\Filament\Resources\TrasladoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Filament\Notifications\Notification;
use App\Models\Traslado;
class CreateTraslado extends CreateRecord
{
    protected static string $resource = TrasladoResource::class;

    protected function beforeCreate(): void
    {
        $data = $this->form->getState();
        $exists = Traslado::where('origen_employee_id',$data['origen_employee_id'])->where('origen_activo_id',$data['origen_activo_id'])->where('destinatario_employee_id',$data['destinatario_employee_id'])->where('aceptado',null)->exists();
        //dd($exists);
        if ($exists) {
            Notification::make()
                ->warning()
                ->title('Ya hay un traslado con los elementos seleccionados en proceso')
                ->body('El traslado existente aun no ha sido aceptado o rechazado')
                ->persistent()
                ->send();
        
            $this->halt();
        }
    }
}
