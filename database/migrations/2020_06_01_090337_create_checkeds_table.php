<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('count_line_id');
            $table->unsignedBigInteger('date_film_id');
            $table->string('card')->unique();
            $table->enum('status', ['active', 'passive'])->default('active');
            $table->timestamps();
            $table->foreign('film_id')->references('id')->on('films')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('count_line_id')->references('id')->on('count_lines')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('date_film_id')->references('id')->on('date_films')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkeds');
    }
}
