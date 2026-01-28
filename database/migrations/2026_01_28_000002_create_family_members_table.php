<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('family_uuid');
            $table->uuid('congregation_uuid');
            $table->string('role')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestampTz('start_date')->nullable();
            $table->timestampTz('end_date')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index('family_uuid');
            $table->index('congregation_uuid');
            $table->index('role');
            $table->index('is_primary');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('deleted_at');

            $table->unique(['family_uuid', 'congregation_uuid']);

            $table->foreign('family_uuid')->references('uuid')->on('families')->cascadeOnDelete();
            $table->foreign('congregation_uuid')->references('uuid')->on('congregations')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
