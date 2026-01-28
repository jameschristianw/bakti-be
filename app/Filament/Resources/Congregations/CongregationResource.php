<?php

namespace App\Filament\Resources\Congregations;

use App\Filament\Resources\Congregations\Pages\CreateCongregation;
use App\Filament\Resources\Congregations\Pages\EditCongregation;
use App\Filament\Resources\Congregations\Pages\ListCongregations;
use App\Filament\Resources\Congregations\Schemas\CongregationForm;
use App\Filament\Resources\Congregations\Tables\CongregationsTable;
use App\Models\Congregation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;
use App\Filament\Resources\Congregations\RelationManagers\FamilyMembersRelationManager;


class CongregationResource extends Resource
{
    protected static ?string $model = Congregation::class;
    protected static bool $isScopedToTenant = false;

    protected static \UnitEnum|string|null $navigationGroup = 'Jemaat';
    protected static ?string $navigationLabel = 'List Jemaat';
    protected static ?int $navigationSort = 1;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static function canManage(): bool
    {
        $user = Filament::auth()?->user();

        if (! $user) {
            return false;
        }

        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('manage Congregation');
    }

    public static function form(Schema $schema): Schema
    {
        return CongregationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CongregationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FamilyMembersRelationManager::class,
        ];
    }    

    public static function getPages(): array
    {
        return [
            'index' => ListCongregations::route('/'),
            'create' => CreateCongregation::route('/create'),
            'edit' => EditCongregation::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return static::canManage();
    }

    public static function canCreate(): bool
    {
        return static::canManage();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canManage();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canManage();
    }

    public static function canDeleteAny(): bool
    {
        return static::canManage();
    }

    public static function canForceDelete(Model $record): bool
    {
        return static::canManage();
    }

    public static function canForceDeleteAny(): bool
    {
        return static::canManage();
    }

    public static function canRestore(Model $record): bool
    {
        return static::canManage();
    }

    public static function canRestoreAny(): bool
    {
        return static::canManage();
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
