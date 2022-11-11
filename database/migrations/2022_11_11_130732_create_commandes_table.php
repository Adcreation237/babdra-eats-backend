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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idplat');
            $table->string('qte');
            $table->string('statut');
            $table->string('date');
            $table->string('heure');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idplat')->references('id')->on('plats')->onDelete('cascade');
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commandes');
        Schema::create('commandes', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('commandes_id_foreign');
        });
    }
};
