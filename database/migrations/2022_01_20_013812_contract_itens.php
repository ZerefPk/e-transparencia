<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_itens', function (Blueprint $table) {
            $table->id();
            $table->integer('item');

            $table->text('description');
            $table->string('unity');
            $table->string('quantity');
            $table->string('unity_value');
            $table->string('total_value');
            $table->unsignedBigInteger('contract_id');
            $table->timestamps();

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts')
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
        Schema::dropIfExists('contract_itens');
    }
}
