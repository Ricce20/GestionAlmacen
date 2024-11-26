<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use Filament\Forms;
use Filament\Forms\Form;
class CredencialesResource extends EditRecord
{
    protected static string $resource = UserResource::class;

    public  function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->regex('/^.+@.+$/i'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->autocomplete('new-password')
                    ->revealable()
                    ->minLength(8)
                    ->maxLength(30)
                    ->confirmed(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->revealable()
                    ->minLength(8)
                    ->maxLength(30)
                    ->password(),
                
            ]);
    }

}
