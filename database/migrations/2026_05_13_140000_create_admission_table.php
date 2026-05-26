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
        Schema::create('admission', function (Blueprint $table) {
            $table->id('admissionid');
            $table->unsignedBigInteger('patient_no');
            $table->unsignedBigInteger('bedid')->nullable();
            $table->dateTime('admissiondate')->nullable();
            $table->dateTime('dischargedate')->nullable();

            // Foreign keys
            $table->foreign('patient_no')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('bedid')->references('bedid')->on('bed')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission');
    }
};
