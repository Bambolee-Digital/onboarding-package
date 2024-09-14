<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
      Schema::table('conditional_messages', function (Blueprint $table) {
          $table->foreignId('question_id')->nullable()->constrained('questions')->onDelete('cascade')->after('id');
      });
  }
  
  

  public function down()
  {
      Schema::table('conditional_messages', function (Blueprint $table) {
          $table->dropForeign(['question_id']);
          $table->dropColumn('question_id');
      });
  }
  

};
