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
        Schema::create('livreurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser');
            $table->string('link_img');
            $table->string('num_cni');
            $table->string('cni_img_1');
            $table->string('cni_img_2');
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
        Schema::dropIfExists('livreurs');
        Schema::create('livreurs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('livreurs_id_foreign');
        });
    }
};
