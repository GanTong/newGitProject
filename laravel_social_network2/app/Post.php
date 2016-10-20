<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	public $timestamps = true;
	protected $table = 'posts';
	protected $guarded = ['id'];


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

  
}
