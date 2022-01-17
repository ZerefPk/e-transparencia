<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PublicationsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('slug');
            $table->boolean('status');
            $table->unsignedBigInteger('publication_template_id');
            $table->timestamps();

            $table->foreign('publication_template_id')
                ->references('id')
                ->on('publications_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications_types');
    }
}
