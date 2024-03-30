<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('planet_histories', function (Blueprint $table) {
            $table->timestamp('created_at')->default(DB::raw('current_timestamp()'))->change();
            $table->timestamp('updated_at')->default(DB::raw('current_timestamp()'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planet_histories', function (Blueprint $table) {
            $table->timestamp('created_at')->useCurrentOnUpdate()->change();
        });
    }
};
