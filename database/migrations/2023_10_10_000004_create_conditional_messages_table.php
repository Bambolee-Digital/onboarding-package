<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionalMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('conditional_messages', function (Blueprint $table) {
            $table->id();
            $table->json('message'); // Campo translatable
            $table->json('conditions'); // Armazena as condições como JSON
            $table->integer('priority')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conditional_messages');
    }
}
