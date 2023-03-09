<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('gov_number')->index();
            $table->string('color');
            $table->string('vin_number')->unique()->index();
            $table->string('manufacturer')->index()->nullable();
            $table->string('model')->index()->nullable();
            $table->string('year')->index()->nullable();
            $table->boolean('stolen')->index()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
