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
        Schema::table('planet_histories', function (Blueprint $table) {
            $table->index([
                'index',
                'valid_start',
                'last_valid'
            ], 'valid_index');
            $table->unsignedBigInteger('last_valid')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planet_histories', function (Blueprint $table) {
            $table->dropIndex('valid_index');
            $table->unsignedBigInteger('last_valid')->nullable(false)->change;
        });
    }
};
