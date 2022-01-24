<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDatePaiement extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->date('date_payment')->nullable();
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('date_payment');
        });
    }
}
