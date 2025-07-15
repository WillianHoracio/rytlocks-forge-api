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
        Schema::create('item_armor_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('infix_id');
            $table->string('type');
            $table->string('weight_class');
            $table->integer('defense');
            $table->float('atribute_adjustment');
            $table->integer('suffix_item_id');
            $table->string('secondary_suffix_item_id');

            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->foreign('infix_id')->references('id')->on('infix_upgrades')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_armor_details');
    }
};
