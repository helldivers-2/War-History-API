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
        Schema::create('planet_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('warId');
            $table->unsignedInteger('index');
            $table->unsignedInteger('owner');
            $table->unsignedInteger('health');
            $table->float('regenPerSecond', 8, 4);
            $table->unsignedInteger('players');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planet_statuses');
    }
};
