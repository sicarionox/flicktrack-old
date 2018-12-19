<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';
    //Primary Key
    public $primaryKey = 'id';

    public $timestamps = false;

    public function MovieRating(){
        return $this->belongsTo('App\Movie');
    }
}
