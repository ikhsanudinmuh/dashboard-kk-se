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
        Schema::create('hkis', function (Blueprint $table) {
            $table->increments('id');
            $table->text('year');
            $table->integer('leader_id')->unsigned()->nullable();
            $table->integer('member_1_id')->unsigned()->nullable();
            $table->integer('member_2_id')->unsigned()->nullable();
            $table->integer('member_3_id')->unsigned()->nullable();
            $table->integer('patent_type_id')->unsigned()->nullable();
            $table->text('creation_type')->nullable();
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('registration_number')->nullable();
            $table->text('sertification_number')->nullable();
            $table->text('hki_file')->nullable();

            $table->timestamps();

            $table->foreign('leader_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_1_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_2_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_3_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('patent_type_id')->references('id')->on('patent_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hkis');
    }
};
