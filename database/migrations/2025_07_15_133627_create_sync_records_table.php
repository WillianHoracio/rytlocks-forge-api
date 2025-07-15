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
        Schema::create('sync_records', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('type');
            $table->boolean('is_synced')->default(true);
            $table->timestamps();

            $table->primary(['id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_records');
    }
};
