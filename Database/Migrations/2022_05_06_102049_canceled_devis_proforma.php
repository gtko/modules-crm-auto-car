<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CanceledDevisProforma extends Migration
{
    public function up()
    {
        Schema::table('proformats', function (Blueprint $table) {
            $table->enum('status', ['normal', 'canceled', 'canceller'])->default('normal');
            $table->unsignedBigInteger('cancel_id')->nullable();
        });

        Schema::table('devis', function (Blueprint $table) {
            $table->enum('status', ['normal', 'canceled', 'canceller'])->default('normal');
            $table->unsignedBigInteger('cancel_id')->nullable();
        });

        Schema::table('invoices', function (Blueprint $table) {
            \DB::statement("ALTER TABLE `invoices` CHANGE `status` `status` ENUM('normal','canceled','canceller') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal';");
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

        Schema::table('invoices', function (Blueprint $table) {
            \DB::statement("ALTER TABLE `invoices` CHANGE `status` `status` ENUM('normal','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal';");
        });
    }
}
