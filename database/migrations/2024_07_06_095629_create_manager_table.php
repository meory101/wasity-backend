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
        Schema::create('manager', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->foreignId('role_id')->constrained('role')->onDelete('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('manager');
    }
};
