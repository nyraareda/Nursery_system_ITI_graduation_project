<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('child_id')->after('class_id');

            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['child_id']);
            $table->dropColumn('child_id');
        });
    }
};
