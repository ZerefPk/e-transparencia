<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BiddingItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_itens', function (Blueprint $table) {
            $table->id();
            $table->integer('item');
            $table->string('catmat')->nullable();
            $table->text('description');
            $table->string('unity');
            $table->string('quantity');
            $table->string('estimated_total_value')->nullable();
            $table->unsignedBigInteger('bidding_id');
            $table->timestamps();

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
        Schema::dropIfExists('bidding_itens');
    }
}
