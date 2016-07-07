<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KickoutFile extends Model
{
    //
    protected $table = 'kickoutFiles';
    protected $primaryKey = 'kickoutFileID';
    public $timestamps = false;


    // partner file for this kickout file
    public function partnerFile() 
    {
        return $this->belongsTo('App\Models\PartnerFile', 'partnerFileID', 'partnerFileID');
    }
}
