<?php

namespace App\Filament\Resources\Pastors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class PastorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                FileUpload::make('picture_url')
                    ->image()
                    ->columnSpanFull()
                    ->directory('pastors')
                    ->label('Picture'),
                TextInput::make('name')
                    ->required(),
                Textarea::make('bio')
                    ->columnSpanFull(),
            ]);
    }
}
