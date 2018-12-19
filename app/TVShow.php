<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TVShow extends Model
{
    //Table Name
    protected $table = 'tv_shows';

    protected $name;
    //Primary Key
    public $primaryKey = 'id';

    public $timestamps = false;

    public function TVRating(){
        return $this->belongsTo('App\TVShow');
    }

    public function getName(){
        return $this->name;
    }
}
