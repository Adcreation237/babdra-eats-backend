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
        Schema::create('plats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idCat');
            $table->string('img_link');
            $table->string('nameplats');
            $table->string('prix');
            $table->string('ingredients');
            $table->string('description');
            $table->string('posted')->default(false);;
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idCat')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('plats');
        Schema::create('plats', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('plats_id_foreign');
        });
    }
};
