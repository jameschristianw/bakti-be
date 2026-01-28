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
        Schema::create('sermon_tag', function (Blueprint $table) {
            $table->uuid('sermon_uuid');
            $table->uuid('tag_uuid');
            $table->foreign('sermon_uuid')->references('uuid')->on('sermons')->onDelete('cascade');
            $table->foreign('tag_uuid')->references('uuid')->on('tags')->onDelete('cascade');
            $table->primary(['sermon_uuid', 'tag_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sermon_tag');
    }
};
