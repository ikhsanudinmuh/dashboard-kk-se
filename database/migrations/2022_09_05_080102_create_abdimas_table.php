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
        Schema::create('abdimas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('year');
            $table->integer('abdimas_type_id')->unsigned()->nullable();
            $table->text('activity_name')->nullable();
            $table->text('title');
            $table->text('status');
            $table->integer('leader_id')->unsigned()->nullable();
            $table->integer('member_1_id')->unsigned()->nullable();
            $table->integer('member_2_id')->unsigned()->nullable();
            $table->integer('member_3_id')->unsigned()->nullable();
            $table->integer('member_4_id')->unsigned()->nullable();
            $table->integer('member_5_id')->unsigned()->nullable();
            $table->integer('lab_id')->unsigned()->nullable();
            $table->text('partner')->nullable();
            $table->text('partner_address')->nullable();
            $table->text('abdimas_file')->nullable();
            $table->timestamps();

            $table->foreign('abdimas_type_id')->references('id')->on('abdimas_types')->onDelete('set null');
            $table->foreign('leader_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_1_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_2_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_3_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_4_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('member_5_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abdimas');
    }
};
