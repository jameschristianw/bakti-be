<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Run permission seeder first
        $this->call(PermissionSeeder::class);
        
        // Create or get Super Admin role
        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin']);
        
        // Create or get admin user
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@gpdibakti.id'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('master123'),
            ]
        );
        
        // Assign Super Admin role to admin user if not already assigned
        if (!$admin->hasRole('Super Admin')) {
            $admin->assignRole($superAdminRole);
        }
        
        $this->command->info('Admin user ready!');
        $this->command->info('Email: admin@gpdibakti.id');
        $this->command->info('Password: master123');
        $this->command->warn('Please change the default password after first login!');
    }
}
