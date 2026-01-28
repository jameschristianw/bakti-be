<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fellowship_user', function (Blueprint $table) {
            $table->id();
            $table->uuid('fellowship_uuid');
            $table->uuid('user_uuid');
            $table->timestamps();

            $table->foreign('fellowship_uuid')->references('uuid')->on('fellowships')->onDelete('cascade');
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fellowship_user');
    }
};
