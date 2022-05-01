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
        Schema::create('replyboards', function (Blueprint $table) {
            $table->increments('reply_post_id');
            $table->string('post_text');
            $table->datetime('send_date');
            $table->bigInteger('post_image_id');
            $table->bigInteger('send_user_id');
            $table->bigInteger('src_post_id');
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
        Schema::dropIfExists('replyboards');
    }
};
