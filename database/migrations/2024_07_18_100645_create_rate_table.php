<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('rate', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('client_id')->constrained('client')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('rate');
    }
};
