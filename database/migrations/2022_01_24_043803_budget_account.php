<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BudgetAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     //
        Schema::create('budget_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('reduced_account')->nullable();
            $table->string('ledger_account');
            $table->string('description');
            $table->boolean('status');
            $table->timestamps();

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
        Schema::dropIfExists('budget_accounts');
    }
}
