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
            $table->decimal('regenPerSecond', 8, 4)->change();
        });

        Schema::table('planets', function (Blueprint $table) {
            $table->decimal('regenPerSecond', 8, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planet_histories', function (Blueprint $table) {
            $table->float('regenPerSecond', 8, 4)->change();
        });

        Schema::table('planets', function (Blueprint $table) {
            $table->float('regenPerSecond', 8, 4)->change();
        });
    }
};
