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
        Schema::create('sermons', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('main_verse')->nullable();
            $table->uuid('pastor_uuid')->nullable();
            $table->foreign('pastor_uuid')->references('uuid')->on('pastors')->onDelete('set null');
            $table->date('sermon_date');
            $table->string('youtube_link')->nullable();
            $table->json('tag')->nullable();
            $table->longText('content')->nullable();
            $table->uuid('author_uuid');
            $table->foreign('author_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sermons');
    }
};
