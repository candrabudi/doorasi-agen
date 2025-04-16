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
        Schema::create('distributor_market_places', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('distributor_id')->constrained('distributors')->cascadeOnDelete();
            $table->foreignId('market_place_id')->constrained('market_places')->cascadeOnDelete();
        
            $table->string('url');
            
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_market_places');
    }
};
