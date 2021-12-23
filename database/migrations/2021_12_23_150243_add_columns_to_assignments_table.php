<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->string('description');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('late_time');
            $table->integer('grade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null')->onUpdate('set null');
            $table->string('pdf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('late_time');
            $table->dropColumn('grade');
            $table->dropColumn('course_id');
            $table->dropColumn('pdf');
        });
    }
}
