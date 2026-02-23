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
        Schema::table('pets', function (Blueprint $table) {
            $table->integer('health')->default(100);
            $table->integer('energy')->default(100);
            $table->integer('cleanliness')->default(100);
            $table->integer('happiness')->default(100);

            $table->boolean('is_alive')->default(true);

            $table->timestamp('last_tick_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn('health');
            $table->dropColumn('energy');
            $table->dropColumn('cleanliness');
            $table->dropColumn('happiness');
            $table->dropColumn('is_alive');
            $table->dropColumn('last_tick_at');
        });
    }
};
