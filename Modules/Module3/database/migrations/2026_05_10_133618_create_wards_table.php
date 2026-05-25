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
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('department_id');
            $table->integer('floor')->nullable();
            $table->integer('capacity')->nullable();
            $table->unsignedBigInteger('ward_head_id')->nullable();
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('ward_head_id')->references('id')->on('users')->onDelete('set null');
            $table->unique(['name', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
