<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->decimal('base_price', 10, 2)->nullable();
            $table->decimal('effective_price', 10, 2)->default(0)->after('base_price')->comment('Price with base price')->index();
            $table->integer('stock')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('has_variants')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
