<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->string('name');
            $table->foreignId('group_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->integer('submissions');
            $table->string('description');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('late_time');
            $table->integer('grade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null')->onUpdate('set null');
            $table->string('pdf')->nullable();
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
        Schema::dropIfExists('assignments');
    }
}
