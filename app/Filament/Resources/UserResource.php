<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Resources\Pages\Page;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nombre de Usuario'),
                Forms\Components\TextInput::make('email')
                    ->hiddenOn('edit')
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->regex('/^.+@.+$/i'),
                Forms\Components\TextInput::make('password')
                    ->hiddenOn('edit')
                    ->password()
                    ->autocomplete('new-password')
                    ->revealable()
                    ->minLength(8)
                    ->maxLength(30)
                    ->confirmed(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->hiddenOn('edit')
                    ->revealable()
                    ->minLength(8)
                    ->maxLength(30)
                    ->password(),
                Forms\Components\Select::make('rol')
                    ->options([
                        'Administrador' => 'Administrador',
                        'Director' => 'Director',
                        'Coordninador' => 'Coordninador',
                        'Empleado' => 'Empleado'
                    ])
                    ->native(false),
                Forms\Components\Select::make('employee_id')
                    ->label('Usuario asignado al Empleado:')
                    ->relationship('employee','nombre',modifyQueryUsing: fn (Builder $query) => $query->where('activo',true))
                    ->preload()
                    ->searchable()
                    ->unique(ignoreRecord: true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre de Usuaio')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500)
                    ->sortable(),
                Tables\Columns\TextColumn::make('rol')
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.nombre')
                    ->searchable()
                    ->label('Nombre de Empleado')
                    ->sortable(),
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
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->where('id','!=',auth()->user()->id));
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'credenciales' => Pages\CredencialesResource::route('/{record}/credencial')
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            // ...
            Pages\CredencialesResource::class,
        ]);
    }
}
