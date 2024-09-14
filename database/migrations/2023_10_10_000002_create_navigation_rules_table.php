<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationRulesTable extends Migration
{
    public function up()
    {
        Schema::create('navigation_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('to_question_id')->constrained('questions')->onDelete('cascade');
            $table->string('response'); // Pode ser um ID de opção ou um valor de resposta
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navigation_rules');
    }
}
