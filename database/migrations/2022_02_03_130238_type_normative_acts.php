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
            $table->string('singular')->unique();
            $table->string('plural')->unique();
            $table->boolean('journaling');
            $table->boolean('status');
            $table->boolean('type')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('can_altered')->nullable();
            $table->text('can_revoked')->nullable();
            $table->string('slug');
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('types_normatives_acts')
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
        Schema::dropIfExists('types_normatives_acts');
    }
}
