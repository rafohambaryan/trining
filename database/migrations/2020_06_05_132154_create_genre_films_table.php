<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_films', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('film_id');
            $table->foreign('genre_id')->references('id')->on('genres')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('film_id')->references('id')->on('films')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genre_films');
    }
}
