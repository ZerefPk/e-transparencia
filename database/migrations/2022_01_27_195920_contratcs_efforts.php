<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContratcsEfforts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('contracts_efforts', function (Blueprint $table) {
            $table->id();
            $table->string('number_effort');
            $table->string('type_effort');
            $table->decimal('total_value', 12,2);
            $table->date('date_effort');
            $table->string('slug_file')->unique();
            $table->string('extension', 35)->nullable();
            $table->text('path', 400);
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('effort_id')->nullable();
            $table->timestamps();

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');


            $table->foreign('effort_id')
                ->references('id')
                ->on('efforts')
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
        //
        Schema::dropIfExists('contracts_efforts');
    }
}
