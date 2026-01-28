<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the admin role exists
        $role = Role::query()->firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => config('auth.defaults.guard', 'web')],
            []
        );

        // Assign all permissions to Super Admin
        $permissions = Permission::query()->pluck('name');
        $role->syncPermissions($permissions);

        // Assign the role to the specific user if present
        $email = env('ADMIN_EMAIL', '');
        $user = User::query()->where('email', $email)->first();

        if (! $user->hasRole('Super Admin')) {
            $user->assignRole($role);
        }
    }
}
