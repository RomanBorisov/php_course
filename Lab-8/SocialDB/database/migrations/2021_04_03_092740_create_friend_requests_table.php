<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id_to')->unsigned();
            $table->bigInteger('user_id_from')->unsigned();
            $table->unsignedTinyInteger('status');
            $table->timestamps();


            $table->foreign('user_id_to')->references('id')->on('users');
            $table->foreign('user_id_from')->references('id')->on('users');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friend_requests');
    }
}
