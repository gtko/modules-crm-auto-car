<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDossierTagTable extends Migration
{
    public function up()
    {
        Schema::create('dossier_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dossier_id');
            $table->unsignedBigInteger('tag_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossier_tag');
    }
}
