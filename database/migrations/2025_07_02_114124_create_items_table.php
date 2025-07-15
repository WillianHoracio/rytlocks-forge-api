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
        Schema::create('items', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('rarity');
            $table->integer('vendor_value')->nullable();
            $table->integer('default_skin')->nullable();
            $table->integer('level')->nullable();
            $table->string('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
