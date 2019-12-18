<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

	protected $table="movies";
    protected $fillable = [
        'key', 'image', 'title','description','rate','vote','user_id'
    ];

     public function rates()
    {
        return $this->hasMany('App\Rate');
    }
}
