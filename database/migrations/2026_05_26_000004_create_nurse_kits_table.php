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
        Schema::create('nurse_kits', function (Blueprint $table) {
            $table->id('nursekitid');
            $table->unsignedBigInteger('staff_id'); // Assigned to which nurse/staff
            $table->unsignedBigInteger('kit_id');
            $table->dateTime('assigned_date');
            $table->dateTime('returned_date')->nullable();
            $table->string('status')->default('assigned'); // 'assigned', 'returned', 'missing'
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kit_id')->references('kitid')->on('hospital_kit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_kits');
    }
};
