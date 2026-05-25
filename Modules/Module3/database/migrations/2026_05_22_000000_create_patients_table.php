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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('allocation_id')->unique();
            $table->foreignId('ward_id')->constrained('wards')->onDelete('cascade');
            $table->date('date_admitted');
            $table->integer('expected_duration')->comment('Duration in days');
            $table->date('date_expected_leave');
            $table->enum('status', ['admitted', 'discharged', 'transferred'])->default('admitted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
