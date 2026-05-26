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
        Schema::create('work_experience', function (Blueprint $table) {
            $table->id('experienceid');
            $table->unsignedBigInteger('staff_id');
            $table->string('organization_name');
            $table->string('position');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('responsibilities')->nullable();
            $table->string('employment_type')->nullable(); // e.g., 'full_time', 'part_time', 'contract'
            $table->timestamps();

            // Foreign key
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experience');
    }
};
