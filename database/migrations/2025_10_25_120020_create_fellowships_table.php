<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fellowships', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->text('name');
            $table->string('short_name', 50);
            $table->text('description');
            $table->string('hex_color', 9);
            $table->string('image_url', 255)->nullable();
            $table->string('level', 50);
            $table->string('location', 255)->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index('deleted_at');
        });

        // Add Postgres uuid[] array column for schedules
        DB::statement("ALTER TABLE fellowships ADD COLUMN schedules uuid[]");
    }

    public function down(): void
    {
        // Drop the Postgres array column explicitly before dropping the table
        DB::statement("ALTER TABLE fellowships DROP COLUMN IF EXISTS schedules");
        Schema::dropIfExists('fellowships');
    }
};
