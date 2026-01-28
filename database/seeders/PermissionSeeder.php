<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // List of all Filament resources
        $resources = [
            'Calendar',
            'Congregation',
            'Education',
            'Event',
            'Fellowship',
            'Gallery',
            'Pastor',
            'Permission',
            'Role',
            'Schedule',
            'Sermon',
            'SundaySchool',
            'SundaySchoolStudent',
            'SundaySchoolTeacher',
            'Tag',
            'User',
        ];

        // Create permissions for each resource
        foreach ($resources as $resource) {
            Permission::firstOrCreate(['name' => "manage {$resource}"]);
        }

        $this->command->info('Permissions created successfully!');
        $this->command->info('Total permissions: ' . count($resources));
    }
}
