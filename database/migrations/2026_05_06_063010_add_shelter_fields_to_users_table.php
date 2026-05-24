<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'volunteer', 'adopter'])->default('adopter');
            $table->string('phone', 20)->nullable();
            $table->string('avatar')->nullable();
            $table->date('volunteer_start_date')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'avatar', 'volunteer_start_date', 'is_active']);
        });
    }
};
