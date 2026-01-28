<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('location', 255);
            $table->integer('day'); // 1..7
            $table->string('note', 255)->nullable();
            $table->string('time', 50)->nullable();
            $table->uuid('fellowship_uuid')->nullable();
            $table->uuid('event_uuid')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('recurring')->default(false);
            $table->string('recurring_type', 10)->default('weekly');
            $table->uuid('events_uuid')->nullable(); // legacy extra column
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index('fellowship_uuid');
            $table->index('event_uuid');
            $table->index('deleted_at');

            $table->foreign('fellowship_uuid')->references('uuid')->on('fellowships')->nullOnDelete();
            $table->foreign('event_uuid')->references('uuid')->on('events')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
