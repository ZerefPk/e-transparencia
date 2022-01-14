<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportDocument extends Migration
{
    /**
    * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_documents', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->date('publication_date');
            $table->string('extension')->nullable();
            $table->string('description')->nullable();
            $table->string('path');
            $table->unsignedBigInteger('report_template_id');
            $table->unsignedBigInteger('report_type_id');
            $table->string('year', 4);
            $table->timestamps();

            $table->foreign('report_template_id')
                ->references('id')
                ->on('report_templates');
            $table->foreign('report_type_id')
                ->references('id')
                ->on('report_types');
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
        Schema::dropIfExists('report_documents');
    }
}
