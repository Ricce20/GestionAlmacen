<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcquisitionTypeResource\Pages;
use App\Filament\Resources\AcquisitionTypeResource\RelationManagers;
use App\Models\AcquisitionType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcquisitionTypeResource extends Resource
{
    protected static ?string $model = AcquisitionType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Gestion de Partidas';

    protected static ?string $pluralModelLabel = 'Tipos de Partidas Especificas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Checkbox::make('es_tipo_venta')
                    ->label('Tipo Venta'),
                Forms\Components\Checkbox::make('es_tipo_donativo')
                    ->label('Tipo Donativo'),
                Forms\Components\Checkbox::make('es_tipo_comodato')
                    ->label('Tipo Comodato'),
                Forms\Components\Checkbox::make('es_tipo_baja')
                    ->label('Tipo Baja'),
                Forms\Components\Checkbox::make('es_tipo_compra')
                    ->label('Tipo Compra'),

                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\IconColumn::make('es_tipo_venta')
                    ->label('Para venta')
                    ->boolean(),
                Tables\Columns\IconColumn::make('es_tipo_donativo')
                    ->label('Para Donativo')
                    ->boolean(),
                Tables\Columns\IconColumn::make('es_tipo_comodato')
                    ->label('Para Comodato')
                    ->boolean(),
                Tables\Columns\IconColumn::make('es_tipo_baja')
                    ->label('Para baja')
                    ->boolean(),
                Tables\Columns\IconColumn::make('es_tipo_compra')
                    ->label('Para Compra')
                    ->boolean(),
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
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAcquisitionTypes::route('/'),
        ];
    }
}
