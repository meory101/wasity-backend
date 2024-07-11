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
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('manager');
    }
};
