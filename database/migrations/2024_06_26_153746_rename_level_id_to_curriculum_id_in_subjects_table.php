<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameLevelIdToCurriculumIdInSubjectsTable extends Migration
{
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->renameColumn('level_id', 'curriculum_id');
        });
    }

    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->renameColumn('curriculum_id', 'level_id');
        });
    }
}
