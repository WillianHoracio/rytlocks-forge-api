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
    public function up()
    {
        Schema::create('item_game_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('game_type');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_game_types');
    }
};
