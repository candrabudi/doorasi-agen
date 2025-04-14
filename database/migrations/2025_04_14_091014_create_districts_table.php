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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('regency_id');
            $table->string('name');
            $table->string('alt_name')->nullable();
            $table->string('slug')->unique();
            $table->decimal('latitude', 10, 5)->nullable();
            $table->decimal('longitude', 10, 5)->nullable();
            $table->timestamps();

            $table->foreign('regency_id')->references('id')->on('regencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
