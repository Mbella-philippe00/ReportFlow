<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('first_name')
                    ->label('Prénom')
                    ->required()
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('department')
                    ->label('Département')
                    ->maxLength(255),

                Toggle::make('active')
                    ->label('Employé actif')
                    ->default(true),

            ]);
    }
}
