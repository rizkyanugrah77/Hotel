<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_units', function (Blueprint $table) {
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available')->change();
        });
    }

    public function down(): void
    {
        DB::table('room_units')->where('status', 'occupied')->update(['status' => 'available']);

        Schema::table('room_units', function (Blueprint $table) {
            $table->enum('status', ['available', 'maintenance'])->default('available')->change();
        });
    }
};
