<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;

class UserResource extends Resource
{    
    protected static ?string $model = User::class;
    protected static bool $isScopedToTenant = false;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-circle';
    protected static \UnitEnum|string|null $navigationGroup = 'Access Control';
    protected static ?string $tenantOwnershipRelationshipName = 'fellowships';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
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

        if (! $currentUser) {
            return $query->whereRaw('1 = 0');
        }

        if (! $currentUser->hasRole('Super Admin') && ! $currentUser->hasRole('Admin')) {
            return $query->whereRaw('1 = 0');
        }

        if (! $currentUser->hasRole('Super Admin')) {
            $query->where('email', '!=', 'admin@gpdibakti.id');
        }

        return $query;
    }
}
