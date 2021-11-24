<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Years extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->string('year', 4);
            $table->boolean('primary');
            $table->boolean('status');
         
            $table->timestamps();

            $table->primary('year');
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
        Schema::dropIfExists('years');
    }
}
