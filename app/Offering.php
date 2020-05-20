<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'price', 'title','userID'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','userID');
    }
}
