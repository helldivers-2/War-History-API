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
        Schema::create('planets', function (Blueprint $table) {
            $table->unsignedBigInteger('index')->primary();
            $table->unsignedInteger('warId');
            $table->unsignedInteger('owner');
            $table->unsignedInteger('health');
            $table->float('regenPerSecond', 8, 4);
            $table->unsignedInteger('players');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};
