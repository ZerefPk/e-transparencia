<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Efforts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('efforts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('year', 4);
            $table->string('number');
            $table->date('date_effort');
            $table->string('type');
            $table->string('reservation_number');
            $table->text('description');
            $table->integer('number_installments');
            $table->decimal('unitary_value', 12,2);
            $table->decimal('total_value', 12,2);
            $table->decimal('adjusted_value', 12,2);
            $table->decimal('current_value', 12,2);
            $table->integer('executed_installments');
            $table->decimal('total_executed', 12,2)->default(0);
            $table->decimal('total_to_executed', 12,2)->default(0);
            $table->boolean('finished');
            $table->boolean('status');
            $table->string('complement')->nullable();
            $table->string('process_number')->nullable();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('subproject_id')->nullable();
            $table->unsignedBigInteger('action_id');
            $table->unsignedBigInteger('budget_account_id');
            $table->unsignedBigInteger('modality_id');
            $table->timestamps();

            $table->foreign('year')
                ->references('year')
                ->on('years')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');

            $table->foreign('project_id')
                ->references('id')
                ->on('budget_ramifications')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('subproject_id')
                ->references('id')
                ->on('budget_ramifications')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('action_id')
                ->references('id')
                ->on('budget_ramifications')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('budget_account_id')
                ->references('id')
                ->on('budget_accounts')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('modality_id')
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
        Schema::dropIfExists('efforts');
    }
}
