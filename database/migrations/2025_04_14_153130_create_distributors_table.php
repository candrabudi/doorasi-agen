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
        Schema::create('distributors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // relasi user
            $table->string('full_name');
            $table->text('address')->nullable();
            
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('email')->nullable();
            
            $table->string('agent_code')->nullable();
            $table->string('google_maps_url')->nullable();
            $table->string('image_url')->nullable();
            
            $table->boolean('is_cod')->default(false);
            $table->boolean('is_shipping')->default(false);
        
            $table->uuid('province_id')->nullable();
            $table->uuid('regency_id')->nullable();
            $table->uuid('district_id')->nullable();
            $table->uuid('village_id')->nullable();
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};
