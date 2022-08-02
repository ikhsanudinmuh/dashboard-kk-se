<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('year');
            $table->integer('writer_1_id')->unsigned();
            $table->integer('writer_2_id')->unsigned()->nullable();
            $table->integer('writer_3_id')->unsigned()->nullable();
            $table->integer('writer_4_id')->unsigned()->nullable();
            $table->integer('writer_5_id')->unsigned()->nullable();
            $table->integer('writer_6_id')->unsigned()->nullable();
            $table->string('lab');
            $table->text('partner_institution')->nullable();
            $table->text('title');
            $table->string('type');
            $table->text('journal_conference');
            $table->string('journal_accreditation');
            $table->text('link');
            $table->text('file')->nullable();
            $table->timestamps();

            $table->foreign('writer_1_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('writer_2_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('writer_3_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('writer_4_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('writer_5_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('writer_6_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
};
