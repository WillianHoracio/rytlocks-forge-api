<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getConnection()
    {
        return 'game-pgsql';
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_item_infix_upgrades', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('skill_id');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_item_infix_upgrades');
    }
};
