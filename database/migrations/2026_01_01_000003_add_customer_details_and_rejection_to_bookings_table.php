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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('tour_package_id');
            $table->string('email')->nullable()->after('full_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('current_location')->nullable()->after('phone');
            $table->string('emergency_contact')->nullable()->after('current_location');
            $table->text('rejection_reason')->nullable()->after('special_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'email',
                'phone',
                'current_location',
                'emergency_contact',
                'rejection_reason',
            ]);
        });
    }
};
