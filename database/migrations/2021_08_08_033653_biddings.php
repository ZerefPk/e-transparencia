<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Biddings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biddings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique();
            $table->string('number');
            $table->text('object')->utf8_encode();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('localization')->nullable();
            $table->string('estimated_value')->nullable();
            $table->string('contracted_value')->nullable();
            $table->text('budget_information')->nullable();
            $table->boolean('status');
            $table->string('year', 4);
            $table->unsignedBigInteger('modality_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('situation_id')->nullable();
            $table->unsignedBigInteger('finality_id')->nullable();

            $table->timestamps();

            $table->foreign('year')
                ->references('year')
                ->on('years')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('modality_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('type_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('situation_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreign('finality_id')
                ->references('id')
                ->on('categories')
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
        Schema::dropIfExists('biddings');
    }
}
