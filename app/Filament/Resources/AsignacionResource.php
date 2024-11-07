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
                    ->relationship('ubicacion','area',
                        modifyQueryUsing: fn (Builder $query) => $query->where('activo',true),
                    )
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
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('fecha_asignacion')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_finalizacion'),
                Forms\Components\Toggle::make('devuelto'),
                Forms\Components\TextInput::make('nota')
                    ->maxLength(255),
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
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_asignacion')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_finalizacion')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('devuelto')
                    ->boolean(),
                Tables\Columns\TextColumn::make('nota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
