<?php

namespace App\Filament\Resources\AsignacionResource\Pages;

use App\Filament\Resources\AsignacionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use App\Models\Asignacion;
use Filament\Notifications\Notification;
class CreateAsignacion extends CreateRecord
{
    protected static string $resource = AsignacionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['activo'] = true;
    
        return $data;
    }

    protected function beforeCreate(): void
    {
        $data = $this->form->getState();
        //dd($data['product_id']);
        $asignacionExiste = Asignacion::where('fecha_finalizacion',null)->where('product_id',$data['product_id'])->exists();
      // dd($asignacionExiste);
        if($asignacionExiste){
            Notification::make()
            ->title('Activo ya ha sido asignado anteriormente')
            ->icon('heroicon-o-document-text')
            ->iconColor('warning')
            ->send();
            $this->halt();

        }
    }

}
