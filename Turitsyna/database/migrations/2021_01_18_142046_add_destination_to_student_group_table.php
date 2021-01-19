<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDestinationToStudentGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_group', function (Blueprint $table) {
            $table->foreignId('student_id');
            $table->foreign('student_id')->references('id')->on('student');

            $table->foreignId('group_id');
            $table->foreign('group_id')->references('id')->on('group');

            $table->foreignId('status_id');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_group', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
}
