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
            $table->integer('author_1_id')->unsigned()->nullable();
            $table->integer('author_2_id')->unsigned()->nullable();
            $table->integer('author_3_id')->unsigned()->nullable();
            $table->integer('author_4_id')->unsigned()->nullable();
            $table->integer('author_5_id')->unsigned()->nullable();
            $table->integer('author_6_id')->unsigned()->nullable();
            $table->integer('lab_id')->unsigned()->nullable();
            $table->text('partner_institution')->nullable();
            $table->text('title');
            $table->integer('publication_type_id')->unsigned()->nullable();
            $table->text('journal_conference');
            $table->integer('journal_accreditation_id')->unsigned()->nullable();
            $table->text('link');
            $table->text('publication_file')->nullable();
            $table->timestamps();

            $table->foreign('author_1_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('author_2_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('author_3_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('author_4_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('author_5_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('author_6_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('set null');
            $table->foreign('publication_type_id')->references('id')->on('publication_types')->onDelete('set null');
            $table->foreign('journal_accreditation_id')->references('id')->on('journal_accreditations')->onDelete('set null');
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
