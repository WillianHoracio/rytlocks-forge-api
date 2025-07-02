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
        Schema::create('game_item_flags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('flag');
            $table->foreign('item_id')->references('id')->on('game_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_item_flags');
    }
};
