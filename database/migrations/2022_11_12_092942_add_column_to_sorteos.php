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
        Schema::table('sorteos', function (Blueprint $table) {
            $table->integer('usa_webservice')->after('es_reventado')->default(0);
            $table->integer('numero_sorteo_webservice')->after('usa_webservice')->default(0);
            $table->text('url_webservice')->after('numero_sorteo_webservice')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sorteos', function (Blueprint $table) {
            $table->dropColumn('usa_webservice');
            $table->dropColumn('numero_sorteo_webservice');
            $table->dropColumn('url_webservice');
        });
    }
};
