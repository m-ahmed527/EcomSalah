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

        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('filepath'); // storage path
            $table->enum('status', ['queued', 'processing', 'done', 'failed'])->default('queued');
            $table->integer('processed')->default(0);
            $table->integer('failed')->default(0);
            $table->string('errors_file')->nullable(); // path to error csv
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imports');
    }
};
