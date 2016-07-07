<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerFile extends Model
{
    //
    protected $table = 'partnerFiles';
    protected $primaryKey = 'partnerFileID';
    public $timestamps = false;

    // Relationships

    // Client for this partner file
    public function client() 
    {
        return $this->belongsTo('App\Models\Client', 'clientID', 'clientID');
    }

    public function kickoutFiles()
    {
        return $this->hasMany('App\Models\KickoutFile', 'partnerFileID', 'partnerFileID');
    }

    public function partner()
    {
        return $this->belongsTo('App\Models\Partner', 'partnerID', 'partnerID');
    }
}
