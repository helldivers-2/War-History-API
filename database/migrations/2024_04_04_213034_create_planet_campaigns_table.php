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
        Schema::create('planet_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->nullable()->primary();
            $table->unsignedBigInteger('planetIndex');
            $table->unsignedInteger('type');
            $table->unsignedInteger('count');
            $table->unsignedBigInteger('warId');
            $table->timestamp('ended_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planet_campaigns');
    }
};
