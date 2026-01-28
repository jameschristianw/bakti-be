<?php

namespace App\Filament\Resources\Congregations\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;


class CongregationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')->required()->maxLength(255),
                TextInput::make('nickname')->required()->maxLength(255),
                TextInput::make('email')->email()->maxLength(255),
                TextInput::make('phone_number')->required()->maxLength(255),
                Textarea::make('address')->required()->rows(3),
                DatePicker::make('birth_date')->required(),
                Select::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ])
                    ->required(),
                TextInput::make('occupation')->maxLength(255),
                // Select::make('education_uuid')
                //     ->label('Education')
                //     ->options(fn () => Education::query()->pluck('education_level', 'uuid'))
                //     ->searchable()
                //     ->preload()
                //     ->native(false),
            ]);
    }
}
