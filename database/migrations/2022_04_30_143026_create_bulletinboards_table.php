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
        Schema::create('bulletinboards  ', function (Blueprint $table) {
            $table->increments('post_id');
            $table->string('post_text');
            $table->bigInteger('post_image_id');
            $table->bigInteger('send_user_id');
            $table->boolean('reply_flag');
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
        Schema::dropIfExists('bulletinboard');
    }
};
