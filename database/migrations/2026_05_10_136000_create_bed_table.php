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
        Schema::create('bed', function (Blueprint $table) {
            $table->id('bedid');
            $table->unsignedBigInteger('wardid');
            $table->string('bednumber');
            $table->string('status')->default('available');

            // Foreign key
            $table->foreign('wardid')->references('id')->on('wards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed');
    }
};
