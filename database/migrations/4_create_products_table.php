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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->string('desc', 255);
            $table->string('full_desc', 1000);
            $table->string('image', 40);
            $table->float('price')->nullable();
            $table->tinyInteger('dispo');
            $table->unsignedBigInteger('gamme_id');
            $table->timestamps();

            $table->foreign('gamme_id')->references('id')->on('gammes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
