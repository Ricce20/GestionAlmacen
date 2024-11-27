<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrasladoResource\Pages;
use App\Filament\Resources\TrasladoResource\RelationManagers;
use App\Models\Traslado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Facades\DB;
use App\Models\Asignacion;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class TrasladoResource extends Resource
{
    protected static ?string $model = Traslado::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        
        return $form
            ->schema([
                Forms\Components\Select::make('origen_employee_id')
                    ->label('Empleado origen')
                    ->relationship(name: 'origen_employee', titleAttribute: 'nombre')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(5)
                    ->required(),
                Forms\Components\Select::make('origen_activo_id')
                    ->label('Activo de Empleado origen')
                    ->required()
                    ->relationship(name: 'origen_activo', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(5)
                    ->hiddenOn(['create','edit']),
                Forms\Components\Select::make('destinatario_employee_id')
                    ->label('Empleado Destino')
                    ->required()
                    ->relationship(name: 'destinatario_employee', titleAttribute: 'nombre')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(5),
                Forms\Components\DatePicker::make('fecha_inicio')
                    ->required(),
                Forms\Components\TextInput::make('motivo_tralado')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('fecha_cierre')
                    ->hiddenOn('create'),
                Forms\Components\Toggle::make('aceptado')
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('motivo_destinatario')
                    ->hiddenOn('create')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
       // dd(Traslado::with('origen_activo')->get());
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('origen_employee.nombre')
                    ->label('Empleado origen')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('origen_activo.name')
                    ->label('Activo de empleado origen')
                    ->searchable()
                    ->sortable()
                    ,
                Tables\Columns\TextColumn::make('destinatario_employee.nombre')
                    ->label('Empleado destino')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('motivo_tralado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_cierre')
                    ->date()
                    ->sortable(),
                    Tables\Columns\IconColumn::make('aceptado')
                    ->color(fn (bool|null $state): string => match ($state) {
                        true => 'success',
                        false => 'warning',
                        null => 'gray',
                    })
                    ->icon(fn (bool|null $state): string => match ($state) {
                        true => 'heroicon-o-pencil',
                        false => 'heroicon-o-x-mark',
                        null => 'heroicon-o-check-circle',
                    }),
                
                Tables\Columns\TextColumn::make('motivo_destinatario')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('confirmar')
                    ->requiresConfirmation()
                    ->action(function($record){
                        //actualizar
                        $asignacionRegistro = Asignacion::find($record->asignacion_id);
                        DB::transaction(function () use ($record,$asignacionRegistro) {
                            $record->update([
                                'fecha_cierre' => now()->timezone('America/Mexico_City')->format('Y/m/d'),
                                'motivo_destinatario' => 'Aceptado correctamente',
                                'aceptado' => true,
                            ]);

                            $asignacionRegistro->update([
                                'fecha_finalizacion' => now()->timezone('America/Mexico_City')->format('Y/m/d'),
                                'devuelto' => true,
                                'nota' => 'El activo a sido trasladado'
                            ]);

                            Asignacion::create([
                                'fecha_asignacion' =>now()->timezone('America/Mexico_City')->format('Y/m/d'),
                                'employee_id' => $record->destinatario_employee_id,
                                'ubicacion_id' => $record->nueva_ubicacion,
                                'product_id' => $asignacionRegistro->product_id,
                                'activo' => true,
                                'tipo_asignacion' => 'Transferido'
                            ]);
                        });

                        // Enviar notificación
                        Notification::make()
                        ->title('Se genero un nuevo registro de asignacion por traslado')
                        ->success()
                        ->send();
                    })
                    ->hidden(fn(Model $record): bool => in_array(auth()->user()->rol, ['Empleado','Administrador']) && $record->destinatario_employee_id !== auth()->user()->employee_id)
                    ->visible(function (Model $record):bool {
                        if($record->aceptado === null) {

                            return true;
                        }else{

                            return false;
                        }
                }),
            Tables\Actions\Action::make('Rechazar')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\TextInput::make('motivo_destinatario')
                    ->label('Motivo del rechazo')
                    ->maxLength(255)
                ])
                ->action(function($record, array $data){
                    $asignacionRegistro = Asignacion::find($record->asignacion_id);

                    //actualizar
                    DB::transaction(function () use ($record, $data,$asignacionRegistro) {
                        $record->update([
                            'fecha_cierre' => now()->timezone('America/Mexico_City')->format('Y/m/d'),
                            'motivo_destinatario' => $data['motivo_destinatario'],
                            'aceptado' => false,
                        ]);

                        $asignacionRegistro->update(['activo' => true]);
                    });

                     // Enviar notificación
                     Notification::make()
                     ->title('El activo volvera a estado activo al empleado origen por rechazo del traslado')
                     ->success()
                     ->send();
                })
                ->hidden(fn(Model $record): bool => in_array(auth()->user()->rol, ['Empleado','Administrador'])  && $record->destinatario_employee_id !== auth()->user()->employee_id)
                ->visible(function (Model $record):bool {
                    // if( is_null($record->activo) && $record->destinatario_employee_id === auth()->user()->employee_id){
                    //     return true;
                    // }
                    // return true;
                    // dd($record->aceptado,$record->destinatario_employee_id === auth()->user()->employee_id);

                    if($record->aceptado === null) {
                        // dd($record);
                         return true;
                     }else{
                         return false;
                     }
                })

                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
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
                        } elseif (in_array($user->rol, ['Director', 'Coordinador'])) {
                           // dd($user);
                            // Limitar resultados al empleado del usuario autenticado
                            $query->where('destinatario_employee_id',auth()->user()->employee_id)
                             ->orWhere('origen_employee_id',auth()->user()->employee_id)
                            ;
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
            'index' => Pages\ListTraslados::route('/'),
            'create' => Pages\CreateTraslado::route('/create'),
            'view' => Pages\ViewTraslado::route('/{record}'),
            'edit' => Pages\EditTraslado::route('/{record}/edit'),
        ];
    }
}
