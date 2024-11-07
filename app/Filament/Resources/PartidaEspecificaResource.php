<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartidaEspecificaResource\Pages;
use App\Filament\Resources\PartidaEspecificaResource\RelationManagers;
use App\Models\PartidaEspecifica;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Wizard;
use Illuminate\Support\HtmlString;
use App\Models\Product;
use Illuminate\Support\Facades\Blade;
use App\Models\Status;
class PartidaEspecificaResource extends Resource
{
    protected static ?string $model = PartidaEspecifica::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('folio')
                    ->label('Folio')
                    ->required()
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nombre_partida')
                    ->label('Nombre de Partida')
                    ->required()
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\Select::make('acquisition_type_id')
                    ->label('Tipo de Partida')
                    ->relationship('acquisition_type','type')
                    ->searchable()
                    ->preload()
                    ->disabled()
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->label('Activo(producto)')
                    ->relationship('product','name')
                    ->searchable()
                    ->preload()
                    ->disabled()
                    ->required(),
                Forms\Components\DatePicker::make('fecha_creacion')
                    ->label('Fecha de Creacion')
                    ->readOnly()
                    ->required(),
                Forms\Components\Select::make('status_id')
                    ->relationship(
                        'status','status',
                        modifyQueryUsing: fn (Builder $query) => $query->where('para_partida',true),
                    )
                    ->disabled()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                ->searchable(),
            Tables\Columns\TextColumn::make('acquisition_type.type')
                ->searchable(),
            Tables\Columns\TextColumn::make('fecha_creacion')
                ->searchable(),
            Tables\Columns\SelectColumn::make('status_id')
            ->options(Status::where('para_partida', true)->pluck('status','id'))
            ->selectablePlaceholder(false)
            ->rules(['required']),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPartidaEspecificas::route('/'),
            'create' => Pages\CreatePartidaEspecifica::route('/create'),
            'edit' => Pages\EditPartidaEspecifica::route('/{record}/edit'),
            'view' => Pages\ViewPartidaEspecifica::route('/{record}/view'),
        ];
    }
}
