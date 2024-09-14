<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->integer('sort')->nullable()->after('text');
        });
    }
  

    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }

};
