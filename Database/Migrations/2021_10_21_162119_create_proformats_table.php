<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformatsTable extends Migration
{
    public function up()
    {
        Schema::create('proformats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->nullable()->unique();
            $table->unsignedBigInteger('devis_id')->index();
            $table->float('total')->default(0);
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proformats');
    }
}
