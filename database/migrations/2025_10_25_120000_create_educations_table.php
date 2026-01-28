<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->text('education_level');
            $table->text('description')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
