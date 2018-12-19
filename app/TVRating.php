<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TVRating extends Model
{
    protected $table = 'ratings_tv';
    public $timestamps = false;

    public function TVShow(){
        return $this->belongsTo('App\TVShow');
    }
}
