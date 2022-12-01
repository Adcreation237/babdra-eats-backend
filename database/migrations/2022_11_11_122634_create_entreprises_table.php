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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser');
            $table->string('link_img');
            $table->string('num_contribuable');
            $table->string('typeentreprise');
            $table->string('heure_open');
            $table->string('heure_deliver');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('entreprises');
        Schema::create('entreprises', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('entreprises_id_foreign');
        });
    }
};
