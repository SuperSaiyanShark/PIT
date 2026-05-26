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
        Schema::create('hospital_kit', function (Blueprint $table) {
            $table->id('kitid');
            $table->string('kit_name');
            $table->text('description')->nullable();
            $table->string('kit_type'); // e.g., 'emergency', 'surgical', 'diagnostic'
            $table->integer('quantity')->default(0);
            $table->string('location')->nullable();
            $table->string('status')->default('available'); // 'available', 'in_use', 'maintenance'
            $table->dateTime('last_checked')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_kit');
    }
};
