<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMargesTable extends Migration
{
    public function up()
    {
        Schema::create('marges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('proformat_id');
            $table->unsignedBigInteger('user_id');
            $table->string('marge');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marges');
    }
}
