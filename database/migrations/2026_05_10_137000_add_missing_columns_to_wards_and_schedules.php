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
        Schema::table('wards', function (Blueprint $table) {
            if (!Schema::hasColumn('wards', 'total_beds')) {
                $table->integer('total_beds')->nullable()->after('capacity');
            }
            if (!Schema::hasColumn('schedules', 'ward_id')) {
                $table->unsignedBigInteger('ward_id')->nullable();
                $table->unsignedBigInteger('shift_date')->nullable();
            }
        });

        Schema::table('schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('schedules', 'ward_id')) {
                $table->unsignedBigInteger('ward_id')->nullable()->after('staff_id');
            }
            if (!Schema::hasColumn('schedules', 'shift_date')) {
                $table->date('shift_date')->nullable()->after('ward_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wards', function (Blueprint $table) {
            if (Schema::hasColumn('wards', 'total_beds')) {
                $table->dropColumn('total_beds');
            }
        });

        Schema::table('schedules', function (Blueprint $table) {
            if (Schema::hasColumn('schedules', 'ward_id')) {
                $table->dropColumn('ward_id');
            }
            if (Schema::hasColumn('schedules', 'shift_date')) {
                $table->dropColumn('shift_date');
            }
        });
    }
};
