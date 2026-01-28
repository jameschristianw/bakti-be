<?php

namespace App\Filament\Resources\Pastors;

use App\Filament\Resources\Pastors\Pages\CreatePastor;
use App\Filament\Resources\Pastors\Pages\EditPastor;
use App\Filament\Resources\Pastors\Pages\ListPastors;
use App\Filament\Resources\Pastors\Schemas\PastorForm;
use App\Filament\Resources\Pastors\Tables\PastorsTable;
use App\Models\Pastor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PastorResource extends Resource
{
    protected static ?string $model = Pastor::class;
    protected static bool $isScopedToTenant = false;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static \UnitEnum|string|null $navigationGroup = 'Ibadah';

    protected static ?string $navigationLabel = 'Daftar Pendeta';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PastorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPastors::route('/'),
            'create' => CreatePastor::route('/create'),
            'edit' => EditPastor::route('/{record}/edit'),
        ];
    }
}
