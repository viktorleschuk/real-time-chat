<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_id')
                ->unsigned();
            $table->integer('user_id')
                ->unsigned();
            $table->text('text');
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table) {

            $table->foreign('channel_id')
                ->references('id')
                ->on('channels')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('user_id')
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
        Schema::table('messages', function (Blueprint $table) {

            $table->dropForeign('messages_channel_id_foreign');
        });

        Schema::drop('messages');
    }
}
