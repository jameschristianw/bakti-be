<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('events', 'is_public')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('is_public');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('events', 'is_public')) {
            Schema::table('events', function (Blueprint $table) {
                $table->boolean('is_public')->default(false);
            });
        }
    }
};
