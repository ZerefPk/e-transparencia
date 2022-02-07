<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NormativeActs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('normatives_acts', function (Blueprint $table) {
            $table->id();
            $table->string('year', 4);
            $table->unsignedBigInteger('type_id');
            $table->string('number');
            $table->text('description');
            $table->text('ementa');
            $table->date('publication_date');
            $table->date('date_journal_publication')->nullable();
            $table->boolean('status');
            $table->boolean('active');
            $table->boolean('altered')->nullable()->default(0);
            $table->boolean('revoked')->nullable()->default(0);
            $table->string('slug');
            $table->string('path_doc')->nullable();
            $table->string('extencion_doc')->nullable();
            $table->string('path_pdf')->nullable();
            $table->string('extencion_pdf')->nullable();

            $table->timestamps();

            $table->foreign('year')
                ->references('year')
                ->on('years')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');

            $table->foreign('type_id')
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
        Schema::dropIfExists('normatives_acts');
    }
}
