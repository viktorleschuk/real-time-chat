<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_user_id')
                ->unsigned();
            $table->integer('second_user_id')
                ->unsigned();
            $table->string('channel_name');
            $table->timestamps();
        });

        Schema::table('channels', function (Blueprint $table) {

            $table->foreign('first_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('second_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channels', function (Blueprint $table) {

            $table->dropForeign('channels_first_user_id_foreign');
            $table->dropForeign('channels_second_user_id_foreign');
        });

        Schema::drop('channels');
    }
}
