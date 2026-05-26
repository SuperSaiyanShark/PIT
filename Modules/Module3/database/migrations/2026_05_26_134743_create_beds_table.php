<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('beds')) {
            Schema::create('beds', function (Blueprint $table) {
                $table->id('bedid');
                $table->string('wardNumber');
                $table->string('bedNumber');
                $table->string('status')->default('Available');
                $table->string('patient_name')->nullable();
                $table->boolean('is_occupied')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};