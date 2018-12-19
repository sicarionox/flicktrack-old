<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('year');
            $table->integer('runtime');
            $table->string('genre');
            $table->date('release_date');
            $table->string('age_rating');
            $table->decimal('imdb_rating');
            $table->decimal('meta_rating');
            $table->integer('local_rating_id');
            $table->mediumText('description');
            $table->mediumText('directors');
            $table->mediumText('actors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
