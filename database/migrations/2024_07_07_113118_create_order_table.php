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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_number');
            $table->integer('status_code');
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('client_id')->constrained('client')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('delivery_man_id')->constrained('delivery_man')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreignId('address_id')->constrained('address')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
