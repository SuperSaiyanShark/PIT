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
        Schema::create('patient', function (Blueprint $table) {
            $table->id('patient_no');
            $table->string('firstname');
            $table->string('lastname');
            $table->date('dob')->nullable();
            $table->char('sex', 1)->nullable();
            $table->text('address')->nullable();
            $table->string('phonenumber')->nullable();
            $table->date('dateregistered')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
    }
};
