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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->date('date_enrolled');
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
