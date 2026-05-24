<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pet_id')->nullable()->constrained('pets')->onDelete('set null');
            $table->date('schedule_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('activity_type', ['walking', 'feeding', 'cleaning', 'grooming', 'other']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_schedules');
    }
};
