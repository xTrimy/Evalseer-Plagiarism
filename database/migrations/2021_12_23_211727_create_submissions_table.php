<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->text('submitted_code');
            $table->text('compile_feedback')->nullable();
            $table->text('style_feedback')->nullable();
            $table->text('logic_feedback')->nullable();
            $table->text('syntax_feedback')->nullable();
            $table->text('feature_feedback')->nullable();
            $table->integer('compiling_grade')->nullable();
            $table->integer('not_hidden_logic_grade')->nullable();
            $table->integer('hidden_logic_grade')->nullable();
            $table->integer('styling_grade')->nullable();
            $table->integer('features_grade')->nullable();
            $table->tinyInteger('reviewed')->nullable();
            $table->text('meta')->nullable();
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
        Schema::dropIfExists('submissions');
    }
}
