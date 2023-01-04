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
        Schema::create('user_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id')->unsigned();
            $table->double('saldo_anterior', 18,3);
            $table->double('premios_del_dia', 18,3)->default(0.000);
            $table->double('ventas_dia', 18,3)->default(0.000);
            $table->double('comisiones_dia', 18,3)->default(0.000);
            $table->double('saldo_final', 18,3)->default(0.000);
            $table->date('fecha_diaria')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_balances');
    }
};
