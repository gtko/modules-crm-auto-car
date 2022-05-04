<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProformatAcceptationDate extends Migration
{
    public function up()
    {
        Schema::table('proformats', function (Blueprint $table) {
            $table->timestamp('acceptation_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('proformats', function (Blueprint $table) {
            $table->dropColumn('acceptation_date');
        });
    }
}
