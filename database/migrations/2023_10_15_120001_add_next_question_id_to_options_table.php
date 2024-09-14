<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNextQuestionIdToOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->unsignedBigInteger('next_question_id')->nullable()->after('message');

            $table->foreign('next_question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropForeign(['next_question_id']);
            $table->dropColumn('next_question_id');
        });
    }
}
