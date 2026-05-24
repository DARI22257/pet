<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('species_id')->constrained('pet_categories')->onDelete('cascade');
            $table->string('breed')->nullable();
            $table->string('age_estimate');
            $table->enum('gender', ['male', 'female']);
            $table->text('description');
            $table->enum('status', ['available', 'treatment', 'adopted', 'reserved'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
