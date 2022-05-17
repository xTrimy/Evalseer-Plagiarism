<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPlagiarismReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plagiarism_reports', function (Blueprint $table) {
            $table->foreignId('submission_id')->nullable()->change()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->string('source_1')->nullable();
            $table->string('source_2')->nullable();
            $table->string('score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plagiarism_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('submission_id');
            $table->integer('submission_id')->change();
            $table->dropColumn('source_1');
            $table->dropColumn('source_2');
            $table->dropColumn('score');
        });
    }
}
