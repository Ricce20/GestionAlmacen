<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierProductRelationManager extends RelationManager
{
    protected static string $relationship = 'SupplierProduct';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Producto')
                    ->relationship(
                        'product','name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('status_id',1),
                    )
                    ->searchable()
                    ->preload()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('precio_compra')
                    ->label('Precio de compra')
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        true => 'Activo',
                        false => 'Inactivo'
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('product.name'),Tables\Columns\TextColumn::make('product.price')
                ->prefix('$')
                ->label('Precio actual del activo'),Tables\Columns\TextColumn::make('precio_compra')
                ->prefix('$')
                ->label('Precio de Compra del Proveedor'),
                Tables\Columns\IconColumn::make('status')
                ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
