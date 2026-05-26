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
        Schema::create('discharge', function (Blueprint $table) {
            $table->id('dischargeid');
            $table->unsignedBigInteger('admissionid');
            $table->dateTime('dischargedate');
            $table->text('discharge_notes')->nullable();
            $table->string('discharge_type')->nullable(); // e.g., 'normal', 'against_medical_advice', 'transferred'
            $table->unsignedBigInteger('discharged_by')->nullable(); // Staff who discharged the patient
            $table->timestamps();

            // Foreign keys
            $table->foreign('admissionid')->references('admissionid')->on('admission')->onDelete('cascade');
            $table->foreign('discharged_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discharge');
    }
};
