<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Eng Nour Othman
     */
    public function up(): void
    {
        Schema::create('delivery_man', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('image')->nullable();
            $table->string('number');
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicle')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('delivery_man');
    }
};
