<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table="rates";
    protected $fillable = [
       'score', 'comment','movie_id','user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
