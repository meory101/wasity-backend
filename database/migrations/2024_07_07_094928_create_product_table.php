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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image');
            $table->foreignId('sub_branch_id')->constrained('sub_branch')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('brand_id')->constrained('brand')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_category_id')->constrained('sub_category')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
