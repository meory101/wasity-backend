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
        Schema::create('payment_summary', function (Blueprint $table) {
            $table->id();
            $table->string('sub_total_value');
            $table->double('sub_total');
            $table->string('total_value');
            $table->double('total');
            $table->string('delivery_fee_value');
            $table->double('delivery_fee');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payment_summary');
    }
};
