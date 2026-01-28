<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Schemas\RoleForm;
use App\Filament\Resources\Roles\Tables\RolesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Filament\Facades\Filament;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static bool $isScopedToTenant = false;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shield-check';

    protected static \UnitEnum|string|null $navigationGroup = 'Access Control';

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    protected static function canManage(): bool
    {
        $user = Filament::auth()?->user();

        if (! $user) {
            return false;
        }

        return $user->hasAnyRole(['Super Admin', 'Admin']);
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $currentUser = Filament::auth()?->user() ?? auth()->user();

        if (! $currentUser->hasRole('Super Admin')) {
            $query->where('name', '!=', 'Super Admin');
        }

        return $query;
    }
}
