<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepreciacionResource\Pages;
use App\Filament\Resources\DepreciacionResource\RelationManagers;
use App\Models\Depreciacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepreciacionResource extends Resource
{
    protected static ?string $model = Depreciacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Gestion_Activos';

    protected static ?string $navigationLabel = 'Gestion Depreciaciones(productos)';

    protected static ?string $pluralModelLabel = 'Registros Depreciaciones(prodcutos)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship(
                        'product','name',   
                         modifyQueryUsing: fn (Builder $query) => $query->where('status_id',1),
                    )
                    ->required(),
                Forms\Components\TextInput::make('anios')
                    ->label('Años para calcular valor de libros')
                    ->suffix(' años')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('fecha_calculo')
                    ->required(),
                Forms\Components\TextInput::make('metodo')
                    ->default('Línea Recta')
                    ->readOnly()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('porcentaje_depreciacion')
                    ->readOnly()
                    ->suffix(' %')
                    ->numeric(),
                Forms\Components\TextInput::make('monto_depreciacion')
                    ->readOnly()
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('valor_libros')
                    ->readOnly()
                    ->prefix('$')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_calculo')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('porcentaje_depreciacion')
                    ->numeric()
                    ->suffix(' %')
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto_depreciacion')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_libros')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
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
            'index' => Pages\ListDepreciacions::route('/'),
            'create' => Pages\CreateDepreciacion::route('/create'),
            'view' => Pages\ViewDepreciacion::route('/{record}'),
            'edit' => Pages\EditDepreciacion::route('/{record}/edit'),
        ];
    }
}
