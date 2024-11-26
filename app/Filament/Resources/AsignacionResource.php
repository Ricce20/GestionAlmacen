<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionResource\Pages;
use App\Filament\Resources\AsignacionResource\RelationManagers;
use App\Models\Asignacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Product;
use App\Models\Ubicacion;
use App\Models\Employee;
use App\Models\Traslado;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\Action;


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AsignacionResource extends Resource
{
    protected static ?string $model = Asignacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->native(false)
                    ->relationship('employee','nombre',
                        modifyQueryUsing: fn (Builder $query) => $query->where('activo',true),
                    )
                    // ->options(Employee::where('activo',true)->pluck('nombre', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('ubicacion_id')
                    ->native(false)
                    ->relationship('ubicacion','area')
                    // ->options(Ubicacion::where('activo',true)->pluck('area', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->native(false)
                    ->relationship(
                        'product','name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('status_id',1),
                    )
                    ->searchable(['name','folio'])
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('fecha_asignacion')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_finalizacion')
                    ->hiddenOn(['edit','create']),
                Forms\Components\Toggle::make('devuelto')
                    ->hiddenOn(['edit','create']),
                Forms\Components\TextInput::make('nota')
                        ->hiddenOn(['edit','create'])
                    ->maxLength(255),
                Forms\Components\Select::make('tipo_asignacion')
                    ->options([
                        'Transferido' => 'Transferido',
                        'Asignado' => 'Asignado',
                    ])
                    ->native(false),
                Forms\Components\Checkbox::make('activo')->inline()
                ->hiddenOn('create')


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ubicacion.area')
                    ->prefix('Area: ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_asignacion')
                    ->date()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('fecha_finalizacion')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('devuelto')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('nota')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualizacion')
                    ->dateTime()
                    ->sortable()
                    // ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('employee_id')
                ->form([
                    Forms\Components\Select::make('value')
                    ->label('Empleado')
                    ->relationship(name: 'employee', titleAttribute: 'nombre')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder => $query->where('employee_id', $value),
                        );
                })
                
                // ->indicateUsing(function (array $data): ?string {
                //     //dd($data);
                //     if (! $data['value']) {
                //         return null;
                //     }
             
                //     return 'Empleado: ' . $data['value'];
                // })
                
                ->indicateUsing(function (array $data): array {
                    $indicators = [];
                
                    if ($data['value'] ?? null) {
                        $employee = Employee::find($data['value']);
                        $employeeName = $employee ? $employee->nombre : 'Desconocido';
                
                        $indicators[] = Indicator::make('Empleado seleccionado: ' . $employeeName)
                            // ->removeField('employee_id')
                            ->removable(false);
                    }
                
                    return $indicators;
                })
                 ->hidden(fn():bool => in_array(auth()->user()->rol,['Empleado','Director','Coordinador']))
                
                
               

            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filtros'),
            )
            ->deferFilters()
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make()
                // ->hidden(fn():bool => in_array(auth()->user()->rol, ['Empleado', 'Director','Coordinador'])),
                Tables\Actions\Action::make('transferir')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Select::make('empleado')
                            ->label('Empleado a quien se desea tranlasar el activo')
                            ->options(Employee::where('activo', true)
                                ->whereIn('posicion', ['Director', 'Coordinador'])->pluck('nombre','id')
                                // ->where('id', '!=', auth()->user()->employee_id)->pluck('nombre','id')
                            )
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10),

                        Forms\Components\TextInput::make('motivo_tralado')
                            ->label('Motivo del traslado')
                            ->required(),
                        Forms\Components\Select::make('nueva_ubicacion')
                            ->native(false)
                           // ->relationship('ubicacion','area')
                            ->options(Ubicacion::all()->pluck('area', 'id'))
                            ->searchable()
                            ->optionsLimit(10)
                            ->preload()
                            ->required(),

                    ])
                    ->action(function ($record,array $data){
                       // dd($record->id);
                        DB::transaction(function () use ($data, $record) {
                            $originalEmployeeId = $record->employee_id; // Guardar el valor original
                            
                            Traslado::create([
                                'asignacion_id' => $record->id,
                                'fecha_inicio' => now()->timezone('America/Mexico_City')->format('Y/m/d'),
                                'origen_employee_id' => $originalEmployeeId,
                                'origen_activo_id' => $record->product_id,
                                'motivo_tralado' => $data['motivo_tralado'],
                                'destinatario_employee_id' => $data['empleado'],
                                'nueva_ubicacion' => $data['nueva_ubicacion']
                            ]);
                        
                            $record->update(['activo' => false]); // Solo actualizar 'activo'
                        });
                        
                            
                            // Enviar notificación
                            Notification::make()
                                ->title('Traslado en proceso. La asignación actual pasará a inactivo hasta que se apruebe o rechace el traslado.')
                                ->success()
                                ->send();

                    })
                    ->hidden(fn(): bool => in_array(auth()->user()->rol, ['Empleado']))
                    ->visible(function(Model $record):bool{
                       if($record->activo){
                            return true;
                       }else{
                        return false;
                       }
                    }),

                    Tables\Actions\Action::make('concluirAsignacion')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\DatePicker::make('fecha_finalizacion')
                                ->required(),
                            Forms\Components\TextInput::make('nota')
                                ->maxLength(255)
                                ->required(),
                            
    
                        ])
                        ->action(function($record, array $data){
                            //actualizar registro
                            DB::transaction(function () use ($data, $record) {
                                $record->update([
                                    'fecha_finalizacion' => $data['fecha_finalizacion'],
                                    'nota' => $data['nota'],
                                    'devuelto' => true,
                                    'activo' => false
                                ]);
                            });

                            // Enviar notificación
                            Notification::make()
                                ->title('Asignacion Del Activo Concluido correctamente')
                                ->success()
                                ->send();

                        })
                        ->hidden(fn(): bool => in_array(auth()->user()->rol, ['Empleado','Director','Coordinador']))
                        ->visible(function(Model $record):bool{
                        if($record->activo){
                                return true;
                        }else{
                            return false;
                        }
                        }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('PDF')
                    ->label('Generar PDF de los Elementos seleccionados')
                    ->color('success')
                    ->requiresConfirmation()    
                    ->icon('heroicon-s-document-arrow-down')
                    ->form([
                        Forms\Components\Select::make('tipoReporte')
                            ->label('Tipo de reporte de Activos')
                            ->options([
                                'Actuales En Uso' => 'Activos en uso(actualmente)',
                                'Finalizados' => 'Activos devueltos(historial)'
                            ])
                            ->required(),
                            Forms\Components\TextInput::make('nota')
                            ->label('Nota del Reporte')
                            ->required()

                    ])
                    ->action(function (Collection $records,Table $table, array $data) {
                       // dd($records,$data);
                        $recordsCound = $records->count();
                        $empleado = auth()->user()->load('employee');
                        //dd($empelado);
                        $minDate = $records->min('fecha_asignacion');
                        $maxDate = $records->max('fecha_asignacion');
                        $horaLocal = Carbon::now('America/Mexico_City')->format('d/m/Y H:i');
                    // dd($records);
                        return response()->streamDownload(function () use ($empleado,$records,$recordsCound,$horaLocal, $minDate,$maxDate,$data){
                            //dd($sumSales,$countSales);
                            echo Pdf::loadHtml(
                                Blade::render('pdf-reporte-asignacion', ['records' => $records,'reporte'=>$data, 'cantidad' => $recordsCound,'fecha'=> $horaLocal,'minDate'=>$minDate,'maxDate'=>$maxDate,'empleado' => $empleado])
                            )->stream(); // Genera el contenido del PDF
                            
                        }, 'Reporte de Asignaciones'.'-'.now().'.pdf');
                    }) 
                    ->deselectRecordsAfterCompletion()    
                ])->label('Acciones'),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                // if (auth()->check()) {
                    $user = auth()->user();
                    //dd($user);
                    // Verificar si el rol del usuario está definido
                    if (!empty($user->rol)) {
                        // Aplicar lógica basada en el rol
                        if ($user->rol === 'Administrador') {
                            // dd($user);
                            $query->withoutGlobalScopes(); // Administrador ve todo
                        } elseif (in_array($user->rol, ['Director', 'Coordinador', 'Empleado'])) {
                           // dd($user);
                            // Limitar resultados al empleado del usuario autenticado
                            $query->where('employee_id', $user->employee_id);
                        }
                    }
                  //  dd($query);
                // }
            });
            
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsignacions::route('/'),
            'create' => Pages\CreateAsignacion::route('/create'),
            'view' => Pages\ViewAsignacion::route('/{record}'),
            'edit' => Pages\EditAsignacion::route('/{record}/edit'),
        ];
    }
}
