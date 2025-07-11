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
        Schema::create('infusion_slots', function (Blueprint $table) {
            $table->id();
            $table->string('flag');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('game_items')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infusion_slots');
    }
};
