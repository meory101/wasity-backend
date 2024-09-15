<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * nour othman
     */
    public function up(): void
    {
        Schema::create('waity_account', function (Blueprint $table) {
            $table->id();
            $table->double('balance');
            $table->foreignId('client_id')->nullable()->constrained('client')->onDelete('cascade');
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_man')->onDelete('cascade');
            $table->foreignId('manager_id')->nullable()->constrained('manager')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waity_account');
    }
};
