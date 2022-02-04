<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TypeNormativeActs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('types_normatives_acts', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->string('plural')->unique();
            $table->boolean('journaling');
            $table->boolean('status');
            $table->text('can_altered')->nullable();
            $table->text('can_revoked')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('types_normatives_acts');
    }
}
