<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->disabled(fn ($record) => 
                        $record && 
                        $record->email === 'admin@gpdibakti.id' && 
                        auth()->user()->email !== 'admin@gpdibakti.id'
                    )
                    ->dehydrated(fn ($state, $record) => 
                        !($record && 
                          $record->email === 'admin@gpdibakti.id' && 
                          auth()->user()->email !== 'admin@gpdibakti.id')
                    ),
                TextInput::make('password')->password()->revealable()->required()->confirmed(),
                TextInput::make('password_confirmation')
                    ->password()
                    ->dehydrated(false)
                    ->requiredWith('password'),
                Select::make('roles')
                    ->multiple()
                    ->relationship(
                        'roles', 
                        'name',
                        fn ($query) => auth()->user()->email !== 'admin@gpdibakti.id' 
                            ? $query->where('name', '!=', 'Super Admin')
                            : $query
                    )
                    ->preload()
                    ->searchable()
                    ->label('Roles'),
            ]);
        // return $schema
        //     ->components([
        //         TextInput::make('name')
        //             ->required(),
        //         TextInput::make('email')
        //             ->label('Email address')
        //             ->email()
        //             ->required(),
        //         DateTimePicker::make('email_verified_at'),
        //         TextInput::make('password')
        //             ->password()
        //             ->required(),
        //         // Textarea::make('two_factor_secret')
        //         //     ->columnSpanFull(),
        //         // Textarea::make('two_factor_recovery_codes')
        //         //     ->columnSpanFull(),
        //         // DateTimePicker::make('two_factor_confirmed_at'),
        //     ]);
    }
}
