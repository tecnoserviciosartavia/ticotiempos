<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venta_detalle', function (Blueprint $table) {
            $table->integer('reventado')->after('monto')->default(0);
            $table->double('monto_reventado', 18,3)->after('reventado')->default(0.000);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venta_detalle', function (Blueprint $table) {
            $table->dropColumn('reventado');
            $table->dropColumn('monto_reventado');
        });
    }
};
