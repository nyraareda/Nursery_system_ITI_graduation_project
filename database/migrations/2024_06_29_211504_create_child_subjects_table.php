<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildSubjectsTable extends Migration
{
    public function up()
    {
        Schema::create('child_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_curriculum_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('child_subjects');
    }
}
