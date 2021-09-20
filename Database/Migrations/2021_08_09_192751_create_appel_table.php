<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppelTable extends Migration
{
    public function up()
    {
        Schema::create('appels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('caller_id');
            $table->text('note')->nullable();
            $table->boolean('joint')->default(false);
            $table->boolean('important')->defaut(false);
            $table->timestamp('date');
            $table->json('datas')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appels');
    }
}
