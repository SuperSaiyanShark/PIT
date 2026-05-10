<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id('PatientID');
            $table->string('FirstName');
            $table->string('LastName');
            $table->date('DOB');
            $table->string('Sex');
            $table->string('Address')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->string('Email')->nullable();
            $table->string('BloodType')->nullable();
            $table->string('Allergies')->nullable();
            $table->string('MedicalConditions')->nullable();
            $table->date('DateRegistered')->nullable();
            $table->timestamps();
        });

        Schema::create('next_of_kins', function (Blueprint $table) {
            $table->id('NOKID');
            $table->unsignedBigInteger('PatientID');
            $table->string('FullName');
            $table->string('Relationship')->nullable();
            $table->string('Address')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->timestamps();
            $table->foreign('PatientID')->references('PatientID')->on('patients')->onDelete('cascade');
        });

        Schema::create('medical_records', function (Blueprint $table) {
            $table->id('RecordID');
            $table->unsignedBigInteger('PatientID');
            $table->string('Diagnosis')->nullable();
            $table->string('Treatment')->nullable();
            $table->date('RecordDate')->nullable();
            $table->text('Notes')->nullable();
            $table->timestamps();
            $table->foreign('PatientID')->references('PatientID')->on('patients')->onDelete('cascade');
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->id('WardID');
            $table->string('WardName');
            $table->string('Location')->nullable();
            $table->integer('TotalBeds')->default(0);
            $table->timestamps();
        });

        Schema::create('local_doctors', function (Blueprint $table) {
            $table->id('DoctorNumber');
            $table->string('FullName');
            $table->string('Address')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->timestamps();
        });

        Schema::create('admissions', function (Blueprint $table) {
            $table->id('AdmissionID');
            $table->unsignedBigInteger('PatientID');
            $table->unsignedBigInteger('WardID')->nullable();
            $table->string('BedNumber')->nullable();
            $table->date('AdmissionDate')->nullable();
            $table->date('DischargeDate')->nullable();
            $table->string('Status')->default('Admitted'); // Admitted, Discharged
            $table->text('DischargeNotes')->nullable();
            $table->timestamps();
            $table->foreign('PatientID')->references('PatientID')->on('patients')->onDelete('cascade');
            $table->foreign('WardID')->references('WardID')->on('wards')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('local_doctors');
        Schema::dropIfExists('wards');
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('next_of_kins');
        Schema::dropIfExists('patients');
    }
};
