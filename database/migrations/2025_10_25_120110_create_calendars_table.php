<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->text('name');
            $table->text('short_name');
            $table->integer('day');
            $table->text('time');
            $table->uuid('fellowship_uuid')->nullable();
            $table->uuid('event_uuid')->nullable();
            $table->string('calendar_color', 8)->nullable();
            $table->text('location');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('fellowship_uuid');
            $table->index('event_uuid');
            $table->index('deleted_at');

            $table->foreign('fellowship_uuid')->references('uuid')->on('fellowships')->nullOnDelete();
            $table->foreign('event_uuid')->references('uuid')->on('events')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
