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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->double('lat');
            $table->double('long');
            $table->foreignId('client_id')->constrained('client')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
