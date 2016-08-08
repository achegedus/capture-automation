<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CatalogService extends Model
{
    //
    protected $table = 'catalogServices';
    protected $primaryKey = 'catalogServiceID';
    public $timestamps = false;
    
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'catalogServiceID', 'catalogServiceID');
    }   
    
}
