<?php

namespace App\Filament\Resources\Sermons\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;


class SermonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('sermon_date')
                    ->required()
                    ->label('Sermon Date'),
                TextInput::make('main_verse')
                    ->maxLength(255)
                    ->label('Main Verse'),
                Select::make('pastor_uuid')
                    ->relationship('pastor', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Pastor'),
                TextInput::make('youtube_link')
                    ->url()
                    ->maxLength(255)
                    ->label('YouTube Link'),
                Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->preload()
                    ->searchable()
                    ->label('Tags'),
                RichEditor::make('content')
                    ->label('Notes')
                    ->extraInputAttributes(['style' => 'min-height: 20rem; max-height: 50vh; overflow-y: auto;'])
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h1',    
                        'h2',
                        'h3',
                        'small',
                        'lead',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->columnSpanFull(),
                Hidden::make('author_uuid')
                    ->default(fn () => auth()->id()),
            ]);
    }
}
