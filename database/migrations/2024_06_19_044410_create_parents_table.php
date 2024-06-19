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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('educational_qualification');
            $table->string('job_title');
            $table->string('workplace');
            $table->string('work_phone');
            $table->string('personal_phone');
            $table->text('address');
            $table->string('home_phone');
            $table->string('street_number');
            $table->string('apartment_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
