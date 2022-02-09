<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactFournisseursAddDevisIdAndIndexTrajet extends Migration
{
    public function up()
    {
        Schema::table('contact_fournisseurs', function (Blueprint $table) {
            $table->unsignedBigInteger('devi_id');
            $table->unsignedBigInteger('trajet_index')->nullable();
        });
    }

    public function down()
    {
        Schema::table('contact_fournisseurs', function (Blueprint $table) {
            $table->dropColumn('devi_id');
            $table->dropColumn('trajet_index');
        });
    }
}
