<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDecaissements extends Migration
{
    public function up()
    {
        Schema::create('decaissements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('devis_id');
            $table->unsignedBigInteger('fournisseur_id');
            $table->float('payer');
            $table->float('restant');
            $table->timestamp('date');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('decaissements');
    }
}
