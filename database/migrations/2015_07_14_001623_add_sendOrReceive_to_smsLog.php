<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSendOrReceiveToSmsLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smsLog', function (Blueprint $table) {
           $table->enum('sendOrReceive', ['S', 'R']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smsLog', function (Blueprint $table) {
            //
        });
    }
}
