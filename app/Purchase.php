<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'customerName', 'offeringID','quantity'
    ];
    public function offering(){
        return $this->belongsTo('App\Offering','offeringID');
    }
}
