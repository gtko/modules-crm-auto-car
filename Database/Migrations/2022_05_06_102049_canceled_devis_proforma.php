<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CanceledDevisProforma extends Migration
{
    public function up()
    {
        Schema::table('proformats', function (Blueprint $table) {
            $table->enum('status', ['normal', 'canceled'])->default('normal');
            $table->unsignedBigInteger('cancel_id')->nullable();
        });

        Schema::table('devis', function (Blueprint $table) {
            $table->enum('status', ['normal', 'canceled'])->default('normal');
            $table->unsignedBigInteger('cancel_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('proformats', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('cancel_id')->nullable();
        });

        Schema::table('devis', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('cancel_id')->nullable();
        });
    }
}
