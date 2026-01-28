<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->text('name');
            $table->text('short_name');
            $table->jsonb('tag');
            $table->text('location');
            $table->uuid('gallery_uuid')->nullable()->index();
            $table->boolean('is_public')->default(false);
            $table->uuid('fellowship_uuid')->nullable()->index();
            $table->string('image_url', 255)->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index('deleted_at');

            // Optional FK for gallery
            $table->foreign('gallery_uuid')->references('uuid')->on('galleries')->nullOnDelete();
            // FK for fellowship
            $table->foreign('fellowship_uuid')->references('uuid')->on('fellowships')->nullOnDelete();
        });

        // Add Postgres uuid[] array column for schedules
        DB::statement("ALTER TABLE events ADD COLUMN schedules uuid[]");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE events DROP COLUMN IF EXISTS schedules");
        Schema::dropIfExists('events');
    }
};
