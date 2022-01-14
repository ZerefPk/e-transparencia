<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('slug');
            $table->boolean('status');
            $table->unsignedBigInteger('report_template_id');
            $table->timestamps();

            $table->foreign('report_template_id')
                ->references('id')
                ->on('report_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_types');
    }
}
