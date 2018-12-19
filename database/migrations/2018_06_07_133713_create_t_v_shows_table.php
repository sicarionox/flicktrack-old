<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTVShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_shows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('start_year');
            $table->integer('end_year');
            $table->integer('season_count');
            $table->integer('avg_runtime');
            $table->string('genre');
            $table->string('broadcaster');
            $table->string('age_rating');
            $table->decimal('imdb_rating');
            $table->decimal('meta_rating');
            $table->integer('local_rating_id');
            $table->longText('description');
            $table->mediumText('creators');
            $table->mediumText('actors');
            $table->string('img');

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_v_shows');
    }
}
