<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
   	protected $fillable = ['id','name','rent','ebase','wbase','fees','deposit'];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
