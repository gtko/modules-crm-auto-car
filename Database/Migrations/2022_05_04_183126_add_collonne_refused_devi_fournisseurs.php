<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollonneRefusedDeviFournisseurs extends Migration
{
    public function up()
    {
        Schema::table('devi_fournisseurs', function (Blueprint $table) {
            $table->boolean('refused')->default(false);

        });
    }

    public function down()
    {
        Schema::table('devi_fournisseurs', function (Blueprint $table) {
            $table->dropColumn('refused');
        });
    }
}
