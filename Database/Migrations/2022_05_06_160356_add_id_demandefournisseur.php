<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdDemandefournisseur extends Migration
{
    public function up()
    {
        Schema::table('devi_fournisseurs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('cancel_id')->nullable();
            $table->enum('status', ['waiting', 'validate', 'BPA', 'canceled', 'refused', 'canceller'])->default('waiting');
            $table->string('payer')->nullable();
            $table->string('reste')->nullable();
            $table->timestamps();
        });

        Schema::table('decaissements', function (Blueprint $table) {
            $table->unsignedBigInteger('demande_id');
        });
    }

    public function down()
    {
        Schema::table('devi_fournisseurs', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('status');
            $table->dropColumn('cancel_id');
            $table->dropColumn('payer');
            $table->dropColumn('reste');
            $table->dropTimestamps();
        });

        Schema::table('decaissements', function (Blueprint $table) {
            $table->dropColumn('demande_id');
        });
    }
}
