<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldTable extends Migration
{
 /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('field_taxonomy_id')->unsigned();
            $table->integer('row_in_file')->unsigned();
           // $table->foreign('field_taxonomy_id')->references('id')->on('field_taxonomy_table')->onDelete('cascade');
            $table->string('value')->nullable();
            $table->softDeletes();
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
        Schema::drop('files');
    }
}
