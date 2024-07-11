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
        Schema::create('sub_branch', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image');
            $table->double('lat');
            $table->double('long');
            $table->foreignId('main_branch_id')->constrained('main_branch')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('manager_id')->constrained('manager')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sub_branch');
    }
};
