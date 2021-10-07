<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('content');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('templates');
    }
}
