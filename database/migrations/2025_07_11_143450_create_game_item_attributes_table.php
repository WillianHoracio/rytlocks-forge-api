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
        Schema::create('game_item_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute');
            $table->integer('modifier');
            $table->unsignedBigInteger('infix_id');
            $table->foreign('infix_id')->references('id')->on('game_item_infix_upgrades')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_item_attributes');
    }
};
