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
        Schema::table('users', function (Blueprint $table) {
            // Add foreign key fields if they don't exist
            if (!Schema::hasColumn('users', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('role');
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('users', 'ward_id')) {
                $table->unsignedBigInteger('ward_id')->nullable()->after('department_id');
                $table->foreign('ward_id')->references('id')->on('wards')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('users', 'staff_role_id')) {
                $table->unsignedBigInteger('staff_role_id')->nullable()->after('ward_id');
                $table->foreign('staff_role_id')->references('id')->on('staff_roles')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('users', 'employment_type')) {
                $table->string('employment_type')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'hire_date')) {
                $table->date('hire_date')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'termination_date')) {
                $table->date('termination_date')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first
            if (Schema::hasColumn('users', 'department_id')) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            }
            
            if (Schema::hasColumn('users', 'ward_id')) {
                $table->dropForeign(['ward_id']);
                $table->dropColumn('ward_id');
            }
            
            if (Schema::hasColumn('users', 'staff_role_id')) {
                $table->dropForeign(['staff_role_id']);
                $table->dropColumn('staff_role_id');
            }
            
            if (Schema::hasColumn('users', 'employment_type')) {
                $table->dropColumn('employment_type');
            }
            
            if (Schema::hasColumn('users', 'hire_date')) {
                $table->dropColumn('hire_date');
            }
            
            if (Schema::hasColumn('users', 'termination_date')) {
                $table->dropColumn('termination_date');
            }
            
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
