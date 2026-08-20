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
        Schema::create('room_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->string('room_number')->unique();
            $table->enum('status', [
                'available',
                'occupied',
                'maintenance',
            ])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_units');
    }
};
