<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->char('sex', 1)->nullable();
            $table->string('marital_status')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('allergies')->nullable();
            $table->string('medical_conditions')->nullable();
            $table->date('date_registered')->nullable();
            $table->timestamps();
        });

        Schema::create('next_of_kins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('full_name');
            $table->string('relationship')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });

        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('diagnosis')->nullable();
            $table->string('treatment')->nullable();
            $table->date('record_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('ward_id')->nullable()->constrained('wards')->onDelete('set null');
            $table->string('bed_number')->nullable();
            $table->date('date_on_waiting_list')->nullable();
            $table->integer('expected_stay_days')->nullable();
            $table->date('date_admitted')->nullable();
            $table->date('date_expected_leave')->nullable();
            $table->date('date_actual_leave')->nullable();
            $table->text('discharge_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('next_of_kins');
        Schema::dropIfExists('patients');
    }
};
