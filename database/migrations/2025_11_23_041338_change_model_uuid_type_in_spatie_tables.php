<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change model_uuid from bigint to uuid in model_has_permissions
        DB::statement('ALTER TABLE model_has_permissions ALTER COLUMN model_uuid TYPE uuid USING model_uuid::text::uuid');

        // Change model_uuid from bigint to uuid in model_has_roles
        DB::statement('ALTER TABLE model_has_roles ALTER COLUMN model_uuid TYPE uuid USING model_uuid::text::uuid');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert model_uuid from uuid to bigint in model_has_permissions
        DB::statement('ALTER TABLE model_has_permissions ALTER COLUMN model_uuid TYPE bigint USING model_uuid::text::bigint');

        // Revert model_uuid from uuid to bigint in model_has_roles
        DB::statement('ALTER TABLE model_has_roles ALTER COLUMN model_uuid TYPE bigint USING model_uuid::text::bigint');
    }
};
