<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveClassIdFromSubjectsTable extends Migration
{

    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            
            $table->dropForeign(['class_id']);

            $table->dropColumn('class_id');
        });
    }


    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->after('id');

            $table->foreign('class_id')->references('id')->on('classes');
        });
    }
}

