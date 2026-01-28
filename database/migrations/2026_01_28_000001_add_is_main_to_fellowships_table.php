<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fellowships', function (Blueprint $table) {
            $table->boolean('is_main')->default(false)->after('level');
        });
    }

    public function down(): void
    {
        Schema::table('fellowships', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });
    }
};
