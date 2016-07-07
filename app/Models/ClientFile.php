<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientFile extends Model
{
    //
    protected $table = 'clientFiles';
    protected $primaryKey = 'clientFileID';
    public $timestamps = false;


    // Relationships

    // Client for this client file
    public function client() 
    {
        return $this->belongsTo('App\Models\Client', 'clientID', 'clientID');
    }
}
