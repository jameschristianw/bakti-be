<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunday_school_students', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('congregation_uuid');
            $table->uuid('sunday_school_uuid')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index('congregation_uuid');
            $table->index('sunday_school_uuid');
            $table->index('deleted_at');

            $table->foreign('congregation_uuid')->references('uuid')->on('congregations')->cascadeOnDelete();
            $table->foreign('sunday_school_uuid')->references('uuid')->on('sunday_schools')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunday_school_students');
    }
};
