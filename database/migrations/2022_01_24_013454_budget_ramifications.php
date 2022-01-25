<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BudgetRamifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('budget_ramifications', function (Blueprint $table) {
            $table->id();
            $table->string('cod');
            $table->string('description');
            $table->string('type');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')
                ->on('budget_ramifications')
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
        Schema::dropIfExists('budget_ramifications');
    }
}
