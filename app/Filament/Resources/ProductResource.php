<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

use App\Models\Clasificacion;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
   
    protected static ?string $navigationGroup = 'Gestion_Activos';

    protected static ?string $navigationLabel = 'Gestion Activos(productos)';

    protected static ?string $pluralModelLabel = 'Registros Activos (prodcutos)';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status_id')
                    ->relationship(
                        'status','status',
                        modifyQueryUsing: fn (Builder $query) => $query->where('para_activo',true),
                    )
                    ->label('Status del activo/producto')
                    ->native(false)
                    ->searchable()
                    ->optionsLimit(5)
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category','category')
                    ->optionsLimit(5)
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('clasificacion_id')
                    ->relationship('clasificacion','clave')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->label('Clasificacion')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label('Descripcion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('brand')
                    ->label('Marca')
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->label('Modelo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('serial_number')
                    ->label('Numero de Serie')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label('Precio o valor del activo')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('vida_util')
                    ->label('Vida util del activo (años)')
                    ->required()
                    ->numeric(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('description')
                //     ->label('Descripcion')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('brand')
                //     ->label('Marca')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('model')
                //     ->label('Modelo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('serial_number')
                //     ->default('N/A')
                //     ->label('Numero de Serie')
                //     ->searchable()
                //     ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Valor')
                    ->prefix('$'),
                Tables\Columns\TextColumn::make('vida_util')
                    ->label('Vida util')
                    ->suffix(' años')
                    ->numeric(),
                Tables\Columns\TextColumn::make('folio')
                    ->label('Folio')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clasificacion.clave')
                    ->label('Clasificacion')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.status')
                    ->color('primary')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                
            ])
            ->filters([ 
                SelectFilter::make('clasificacion_id')
                // ->preload()
                ->relationship('clasificacion', 'clave')
                ->label('Clasificacion')
                //->searchable()
                //->preload()
                // ->options(Clasificacion::all()->pluck('clave', 'clave'))
                    //->searchable()
                
               // ->optionsLimit(5)
               // ->attribute('clasificacion_id')


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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
