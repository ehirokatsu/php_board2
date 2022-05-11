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
        Schema::create('boardimages', function (Blueprint $table) {
            $table->bigInteger('post_id')->unsigned();
            $table->string('image_name');
            $table->primary('post_id');
            $table->foreign('post_id')->references('id')->on('boards')->onDelete('CASCADE');
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
        Schema::dropIfExists('boardimages');
    }
};
