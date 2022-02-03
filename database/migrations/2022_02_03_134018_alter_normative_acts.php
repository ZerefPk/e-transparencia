<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNormativeActs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('alters_normatives_acts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('normative_act_id');
            $table->tinyInteger('type');
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('normatives_acts')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('normative_act_id')
                ->references('id')
                ->on('normatives_acts')
                ->onDelete('RESTRICT')
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
        Schema::dropIfExists('alters_normatives_acts');
    }
}
