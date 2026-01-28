<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('congregations', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->text('full_name');
            $table->text('nickname');
            $table->text('email')->nullable();
            $table->text('phone_number');
            $table->text('address');
            $table->timestamp('birth_date');
            $table->text('gender');
            $table->text('occupation')->nullable();
            $table->uuid('education_uuid')->nullable()->index();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->unique('email');
            $table->index('deleted_at');

            $table->foreign('education_uuid')->references('uuid')->on('educations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('congregations');
    }
};
