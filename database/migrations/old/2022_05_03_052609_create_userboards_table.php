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
        //外部キーの参照先と合わせるためにunsigned()を使用している
        Schema::create('userboards', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('post_id')->unsigned();
            $table->primary(['user_id', 'post_id']);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('CASCADE');
            $table->foreign('post_id')->references('post_id')->on('boards')->onDelete('CASCADE');
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
        Schema::dropIfExists('userboards');
    }
};
