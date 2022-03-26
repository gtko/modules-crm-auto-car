<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJsonTableContactFournisseur extends Migration
{
    public function up()
    {
        Schema::table('contact_fournisseurs', function (Blueprint $table) {
            $table->json('data')->nullable();
        });
    }

    public function down()
    {
        Schema::table('contact_fournisseurs', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
}
