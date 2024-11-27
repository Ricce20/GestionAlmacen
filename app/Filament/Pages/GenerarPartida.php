<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Wizard;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;

use Filament\Forms\Get;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

use App\Models\Product;
use App\Models\AcquisitionType;
use App\Models\PartidaEspecifica;
use App\Models\ObjetoGasto;
use App\Models\Factura;
use App\Models\Status;
class GenerarPartida extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.generar-partida';

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user->rol == 'Administrador' ?  true : false;
    }

    public function mount(): void
    {
        $this->form->fill();
    }
    //form
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Crear Partida Especifica')
                        ->schema([
                            Forms\Components\TextInput::make('nombre_partida')
                                ->required(),

                            Forms\Components\Select::make('acquisition_type_id')
                                ->label('Tipo de Partida')
                                ->options(AcquisitionType::all()->pluck('type', 'id'))
                                ->native(false)
                                ->preload()
                                ->required()
                                ->live(),

                            Forms\Components\Select::make('status_id')
                                ->options(Status::where('para_partida', true)->pluck('status','id'))
                                ->native(false)
                                ->preload()
                                ->required(),
                        ]),

                    Wizard\Step::make('Seleccionar Activo')
                        ->schema([
                            Forms\Components\Select::make('product_id')
                                ->label('Producto')
                                ->options(Product::where('status_id', 1)->pluck('name', 'id'))
                                ->native(false)
                                ->searchable()
                                ->preload()
                                ->required()
                        ])
                        ->visible(fn (Get $get) => in_array(
                            $get('acquisition_type_id'), 
                            AcquisitionType::whereIn('id', [
                                AcquisitionType::where('es_tipo_baja', true)->value('id'),
                                AcquisitionType::where('es_tipo_donativo', true)->value('id'),
                                AcquisitionType::where('es_tipo_comodato', true)->value('id')
                            ])->pluck('id')->toArray()
                        )),


                    Wizard\Step::make('Objeto de gasto')
                        ->schema([
                            Forms\Components\TextInput::make('cuenta')
                                ->required(),
                            Forms\Components\TextInput::make('concepto')
                                ->required(),
                            Forms\Components\TextInput::make('vida')
                                ->required()
                                ->numeric(),
                            Forms\Components\Select::make('product_id')
                                ->label('Producto')
                                ->options(Product::where('status_id', 1)->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\TextInput::make('costo')
                                ->required()
                                ->numeric(),
                        ])
                        ->hidden(fn (Get $get) => in_array(
                            $get('acquisition_type_id'), 
                            AcquisitionType::whereIn('id', [
                                AcquisitionType::where('es_tipo_baja', true)->value('id'),
                                AcquisitionType::where('es_tipo_donativo', true)->value('id'),
                                AcquisitionType::where('es_tipo_comodato', true)->value('id')
                            ])->pluck('id')->toArray()
                        )),
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Submit
                    </x-filament::button>
                BLADE)))
            ])
            ->statePath('data');
    }
   
     
    public function create(): void
    {
       // dd($this->data);
        // Creamos la partida
        $partida = $this->createPartida();

        // Validamos el tipo de partida
        if (AcquisitionType::where('es_tipo_baja', true)->where('id', $this->data['acquisition_type_id'])->exists()) {
            // Si es de tipo baja
            $statusId = (intval($this->data['status_id']) === 4) ? 6 : 2;
            // dd($statusId);
            // Asegúrate de que product() devuelva el modelo para aplicar update()
            $partida->product()->update(['status_id' => $statusId]);
            
            $statusMessage = $statusId === 6 ? 'Baja' : 'Inactivo';
           // dd($statusMessage);
            Notification::make()
                ->title('Partida Generada Correctamente')
                ->success()
                ->body("Activo ha cambiado de estado a: $statusMessage. Folio: {$partida->folio}")
                ->send();
            
            // Limpia el formulario y redirige
            $this->data = [];
            $this->form->fill([]);
            redirect()->route('filament.gestion.pages.generar-partida');
            return;
        }
        
        // Validamos si no es compra
        $no_es_compra = $this->validateAcquisitionType($this->data['acquisition_type_id']);
        
        if ($no_es_compra) {
            Notification::make()
                ->title('Partida Generada Correctamente')
                ->success()
                ->body("Consulte la partida con el folio: {$partida->folio}")
                ->send();
            
            // Limpia el formulario y redirige
            $this->form->fill([]);
            redirect()->route('filament.gestion.pages.generar-partida');
            return;
        } else{
            // Si es compra, crea objeto de gasto y factura
            $objetoGasto = $this->createObjetoGasto($partida->id);
            $this->createFactura($objetoGasto->id);

            $this->form->fill([]);
            Notification::make()
                ->title('Partida Generada Correctamente')
                ->success()
                ->body('Puede revisar la partida en el gestor de partidas')
                ->send();

            // Redirige después de enviar la notificación
            redirect()->route('filament.gestion.pages.generar-partida');
            return;
        }
            
        
    }


    private function validateAcquisitionType($acquisition_id):bool{

        //obtenemos los valores de la db
        $validAcquisitionTypeIds = AcquisitionType::whereIn('id', [
            AcquisitionType::where('es_tipo_donativo', true)->value('id'),
            AcquisitionType::where('es_tipo_comodato', true)->value('id')
        ])->pluck('id')->toArray();
        // Validar si `acquisition_type_id` está en el array y ejecutar código según el caso
        return in_array($acquisition_id, $validAcquisitionTypeIds);
    }

    private function createPartida():PartidaEspecifica{
        $partida = new PartidaEspecifica();
        $partida->folio = PartidaEspecifica::generarFolioUnico();
        $partida->nombre_partida = $this->data['nombre_partida'];
        $partida->acquisition_type_id = $this->data['acquisition_type_id'];
        $partida->fecha_creacion = now();
        $partida->product_id = $this->data['product_id'] ?? null;
        $partida->status_id = $this->data['status_id'];
        // dd($partida);
        $partida->save();
        return $partida;
    }

    private function createObjetoGasto($partida_id):ObjetoGasto{
        $objetoGastoData = $this->data;
        $objetogasto = new ObjetoGasto();
        $objetogasto->cuenta = $objetoGastoData['cuenta'];
        $objetogasto->concepto = $objetoGastoData['concepto'];
        $objetogasto->vida = $objetoGastoData['vida'];
        $objetogasto->product_id = $objetoGastoData['product_id'];
        $objetogasto->partida_especifica_id = $partida_id;
        $objetogasto->save();
        return $objetogasto;
        
    }

    private function createFactura($objetoGasto_id){
        $facturaData = $this->data;
        $factura = new Factura();
        $factura->folio_factura = Factura::generarFolioUnico();
        $factura->fecha_factura = now();
        $factura->costo = $facturaData['costo'];
        $factura->objeto_gasto_id = $objetoGasto_id;
        $factura->save();
    }
}
