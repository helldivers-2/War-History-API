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
            $table->unsignedBigInteger('valid_start');
            $table->unsignedBigInteger('last_valid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planet_histories', function (Blueprint $table) {
            $table->removeColumn('valid_start');
            $table->removeColumn('last_valid');
        });
    }
};
