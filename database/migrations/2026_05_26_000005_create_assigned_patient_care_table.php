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
        Schema::create('assigned_patient_care', function (Blueprint $table) {
            $table->id('assignmentid');
            $table->unsignedBigInteger('admissionid');
            $table->unsignedBigInteger('staff_id');
            $table->dateTime('assignment_date');
            $table->dateTime('end_date')->nullable();
            $table->text('care_notes')->nullable();
            $table->string('care_type'); // e.g., 'primary_nurse', 'consulting_doctor', 'therapist'
            $table->string('status')->default('active'); // 'active', 'completed', 'transferred'
            $table->timestamps();

            // Foreign keys
            $table->foreign('admissionid')->references('admissionid')->on('admission')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_patient_care');
    }
};
