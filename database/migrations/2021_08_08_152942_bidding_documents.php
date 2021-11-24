<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BiddingDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bidding_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('extension',35)->nullable();
            $table->string('description')->nullable();
            $table->text('path', 400);
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
        Schema::dropIfExists('bidding_documents');
    }
}
