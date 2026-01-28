<?php

namespace App\Filament\Resources\Families\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class FamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('family_name')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('start_at')
                    ->label('Menikah Pada')
                    ->native(false),
                Textarea::make('address')
                    ->rows(3)
                    ->maxLength(65535),
                Textarea::make('notes')
                    ->rows(3)
                    ->maxLength(65535),
            ]);
    }
}
