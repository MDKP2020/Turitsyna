<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDestinationToGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group', function (Blueprint $table) {
            $table->foreignId('study_year_id')->nullable();
            $table->foreign('study_year_id')->references('id')->on('study_year');

            $table->foreignId('direction_id')->nullable();;
            $table->foreign('direction_id')->references('id')->on('direction');

            $table->foreignId('lvl_education_id')->nullable();;
            $table->foreign('lvl_education_id')->references('id')->on('level_education');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group', function (Blueprint $table) {
            $table->dropForeign(['study_year_id']);
            $table->dropColumn('study_year_id');
            $table->dropForeign(['direction_id']);
            $table->dropColumn('direction_id');
            $table->dropForeign(['lvl_education_id']);
            $table->dropColumn('lvl_education_id');
        });
    }
}
