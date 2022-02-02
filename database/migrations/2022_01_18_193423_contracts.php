<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('number');
            $table->text('object');
            $table->string('process_number')->nullable();
            $table->unsignedBigInteger('form_contract_id')->nullable();
            $table->unsignedBigInteger('form_payment_id');
            $table->unsignedBigInteger('situation_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('overall_contract_value')->nullable();
            $table->string('legal_foundation')->nullable();
            $table->date('signature_date');
            $table->date('start_validity');
            $table->date('end_term');
            $table->string('contract_tax')->nullable();
            $table->string('contract_manager')->nullable();
            $table->boolean('status');
            $table->string('year', 4);
            $table->unsignedBigInteger('bidding_id')->nullable();
            $table->unsignedBigInteger('provider_id');
            $table->timestamps();


            $table->foreign('form_payment_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('form_contract_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('situation_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('subject_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('year')
                ->references('year')
                ->on('years')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('bidding_id')
                ->references('id')
                ->on('biddings')
                ->onDelete('SET NULL')
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
        Schema::dropIfExists('contracts');
    }
}
