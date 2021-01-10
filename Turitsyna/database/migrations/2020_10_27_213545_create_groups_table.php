<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('educ_form_id');
            $table->unsignedBigInteger('lvl_education_id');
            $table->unsignedBigInteger('study_year_id');
            $table->foreign('educ_form_id')->references('id')->on('education_form');
            $table->foreign('lvl_education_id')->references('id')->on('level_education');
            $table->foreign('study_year_id')->references('id')->on('study_year');
            $table->integer('course');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
