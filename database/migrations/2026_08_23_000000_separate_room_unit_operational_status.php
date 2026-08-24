<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Existing occupied values were derived from bookings, not operational state.
        DB::table('room_units')->where('status', 'occupied')->update(['status' => 'available']);

        Schema::table('room_units', function (Blueprint $table) {
            $table->enum('status', ['available', 'maintenance'])->default('available')->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->index(
                ['room_unit_id', 'status', 'check_in', 'check_out'],
                'bookings_availability_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_availability_index');
        });

        Schema::table('room_units', function (Blueprint $table) {
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available')->change();
        });
    }
};
