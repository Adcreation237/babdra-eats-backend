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
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idlivreur')->nullable();
            $table->unsignedBigInteger('idresto');
            $table->unsignedBigInteger('plats');
            $table->string('amount');
            $table->string('position');
            $table->string('long');
            $table->string('lat');
            $table->string('statut')->default('encours');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idlivreur')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idresto')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plats')->references('id')->on('plats')->onDelete('cascade');
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
        Schema::dropIfExists('livraisons');
        Schema::create('livraisons', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('livraisons_id_foreign');
        });
    }
};
