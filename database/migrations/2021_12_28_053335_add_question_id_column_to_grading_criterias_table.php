<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionIdColumnToGradingCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grading_criterias', function (Blueprint $table) {
            $table->foreignId('question_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grading_criterias', function (Blueprint $table) {
            $table->dropConstrainedForeignId('question_id');
            $table->dropColumn('question_id');
        });
    }
}
