<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	protected $table="posts";
    protected $fillable = [
       'image', 'title','description','user_id','slug'
    ];


}
