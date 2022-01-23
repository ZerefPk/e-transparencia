<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractAmendment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractual_amendment', function (Blueprint $table) {
            $table->id();
            $table->integer('sequence');

            $table->text('description')->nullable();
            $table->string('type_modification');
            $table->string('decrease_value')->nullable();
            $table->string('addition_value')->nullable();
            $table->string('termination_value')->nullable();
            $table->string('total_value')->nullable();
            $table->date('signature_date');
            $table->date('start_validity')->nullable();
            $table->date('end_term')->nullable();
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
        Schema::dropIfExists('contractual_additives');
    }
}
