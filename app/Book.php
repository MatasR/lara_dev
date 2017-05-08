<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
	use SoftDeletes;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['name', 'author_id'];
	protected $dates = ['deleted_at'];

	public function author(){
		return $this->belongsTo('App\Author');
	}
}
