<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ObjetoGastoResource\Pages;
use App\Filament\Resources\ObjetoGastoResource\RelationManagers;
use App\Models\ObjetoGasto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObjetoGastoResource extends Resource
{
    protected static ?string $model = ObjetoGasto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('partida_especifica_id')
                    ->numeric(),
                Forms\Components\TextInput::make('cuenta')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('concepto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('vida')
                    ->required()
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
                Tables\Columns\TextColumn::make('partida_especifica.nombre_partida')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cuenta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('concepto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vida')
                    ->numeric()
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
            'index' => Pages\ListObjetoGastos::route('/'),
            'create' => Pages\CreateObjetoGasto::route('/create'),
            'view' => Pages\ViewObjetoGasto::route('/{record}'),
            'edit' => Pages\EditObjetoGasto::route('/{record}/edit'),
        ];
    }
}
