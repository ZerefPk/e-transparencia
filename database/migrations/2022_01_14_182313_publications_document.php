<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PublicationsDocument extends Migration
{
    /**
    * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications_documents', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->date('publication_date');
            $table->string('extension')->nullable();
            $table->string('description')->nullable();
            $table->string('path');
            $table->unsignedBigInteger('publication_template_id');
            $table->unsignedBigInteger('publication_type_id');
            $table->string('year', 4);
            $table->timestamps();

            $table->foreign('publication_template_id')
                ->references('id')
                ->on('publications_templates');
            $table->foreign('publication_type_id')
                ->references('id')
                ->on('publications_types');
            $table->foreign('year')
                ->references('year')
                ->on('years')
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
        Schema::dropIfExists('publications_documents');
    }
}
