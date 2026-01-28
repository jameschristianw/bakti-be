<?php

namespace App\Filament\Resources\Congregations\RelationManagers;

use App\Models\Family;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class FamilyMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'familyMembers';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('family_uuid')
                ->label('Family')
                ->options(fn () => Family::query()->orderBy('family_name')->pluck('family_name', 'uuid'))
                ->searchable()
                ->preload()
                ->required()
                ->native(false),
            Select::make('role')
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
            Toggle::make('is_primary')
                ->columnSpanFull()
                ->label('Primary family')
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Keluarga')
            ->columns([
                TextColumn::make('family.family_name')
                    ->label('Family'),
                    // ->searchable(),
                TextColumn::make('role')
                    ->badge(),
                IconColumn::make('is_primary')
                    ->boolean(),
                TextColumn::make('end_date')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
