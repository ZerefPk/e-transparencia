<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BiddingsWinrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biddings_winrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidding_item_id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('bidding_id');
            $table->string('approved_value')->nullable();
            $table->timestamps();

            $table->foreign('bidding_item_id')
                ->references('id')
                ->on('bidding_itens')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('bidding_id')
                ->references('id')
                ->on('biddings')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('biddings_winrs');
    }
}
