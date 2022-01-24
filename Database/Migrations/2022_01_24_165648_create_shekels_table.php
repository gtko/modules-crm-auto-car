<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShekelsTable extends Migration
{
    public function up()
    {
        Schema::create('shekels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('shekel');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shekels');
    }
}
