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
        Schema::table('galleries', function (Blueprint $table) {
            $table->uuid('fellowship_uuid')->nullable()->after('uuid');
            $table->foreign('fellowship_uuid')->references('uuid')->on('fellowships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
			$table->dropForeign(['fellowship_uuid']);
			$table->dropColumn('fellowship_uuid');
        });
    }
};
