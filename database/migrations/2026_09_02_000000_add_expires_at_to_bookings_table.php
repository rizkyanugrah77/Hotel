<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dateTime('expires_at')->nullable()->after('status');
            $table->index(['status', 'expires_at'], 'bookings_hold_expiry_index');
        });

        DB::table('bookings')
            ->where('status', 'pending')
            ->whereNull('expires_at')
            ->update(['expires_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_hold_expiry_index');
            $table->dropColumn('expires_at');
        });
    }
};
