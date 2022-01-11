<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFournisseursTable extends Migration
{
    public function up()
    {
        Schema::create('contact_fournisseurs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('dossier_id');
            $table->unsignedBigInteger('fournisseur_id');
            $table->string('name');
            $table->string('phone');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_fournisseurs');
    }
}
