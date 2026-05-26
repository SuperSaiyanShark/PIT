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
        Schema::table('admission', function (Blueprint $table) {
            // Add Staff_no column if it doesn't exist
            if (!Schema::hasColumn('admission', 'Staff_no')) {
                $table->integer('Staff_no')->nullable()->after('BedID');
            }
            
            // Add reason column if it doesn't exist
            if (!Schema::hasColumn('admission', 'reason')) {
                $table->text('reason')->nullable()->after('DischargeDate');
            }
            
            // Add notes column if it doesn't exist
            if (!Schema::hasColumn('admission', 'notes')) {
                $table->text('notes')->nullable()->after('reason');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission', function (Blueprint $table) {
            $table->dropColumn(['Staff_no', 'reason', 'notes']);
        });
    }
};
