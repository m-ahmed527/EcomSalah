<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('sripe_price_id')->unique()->comment('Stripe Price ID');
            $table->string('sripe_product_id')->unique()->comment('Stripe Product ID');
            $table->string('name');
            $table->integer('amount');
            $table->string('interval');
            $table->integer('trial_days')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('uses')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
