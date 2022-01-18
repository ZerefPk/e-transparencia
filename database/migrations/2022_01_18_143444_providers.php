<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Providers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('corporate_name');
            $table->string('fantasy_name')->nullable();
            $table->string('legal_nature')->nullable();
            $table->string('mei_company')->nullable();
            $table->string('headquarters')->nullable();
            $table->boolean('status');
            $table->boolean('type');
            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();
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
        Schema::dropIfExists('providers');
    }
}
