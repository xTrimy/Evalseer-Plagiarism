<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_criterias', function (Blueprint $table) {
            $table->id();
            $table->integer('compiling_weight')->nullable();
            $table->integer('styling_weight')->nullable();
            $table->integer('logic_weight')->nullable();
            $table->integer('hidden_test_cases_weight')->nullable();
            $table->integer('not_hidden_test_cases_weight')->nullable();
            $table->integer('features_weight')->nullable();
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
        Schema::dropIfExists('grading_criterias');
    }
}
