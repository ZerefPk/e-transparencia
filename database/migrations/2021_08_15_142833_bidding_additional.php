<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BiddingAdditional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //S
        Schema::create('biddings_additional', function (Blueprint $table) {
            $table->id();
            $table->string('notice_number');
            $table->date('bid_opening_date')->nullable();
            $table->time('bid_opening_hour')->nullable();
            $table->date('bid_closing_date')->nullable();
            $table->time('bid_closing_hour')->nullable();
            $table->text('description')->nullable();
         
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
        Schema::dropIfExists('biddings_additional');
    }
}
