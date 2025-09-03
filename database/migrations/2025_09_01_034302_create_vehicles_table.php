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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('type', ['car', 'van', 'tuk-tuk'])->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
