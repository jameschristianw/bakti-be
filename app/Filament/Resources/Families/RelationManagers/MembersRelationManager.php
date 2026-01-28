<?php

namespace App\Filament\Resources\Families\RelationManagers;

use App\Models\Congregation;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('congregation_uuid')
                ->label('Congregation')
                ->options(fn () => Congregation::query()->orderBy('full_name')->pluck('full_name', 'uuid'))
                ->searchable()
                ->preload()
                ->required()
                ->native(false),
            Forms\Components\Select::make('role')
                ->options([
                    'Head' => 'Head',
                    'Spouse' => 'Spouse',
                    'Child' => 'Child',
                    'Parent' => 'Parent',
                    'Sibling' => 'Sibling',
                    'Other' => 'Other',
                ])
                ->native(false)
                ->searchable(),
            Forms\Components\Toggle::make('is_primary')
                ->label('Primary family')
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('congregation.full_name')
                    ->label('Congregation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_primary')
                    ->boolean()
                    ->toggleable(),
                // Tables\Columns\TextColumn::make('end_date')
                //     ->dateTime()
                //     ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }
}
