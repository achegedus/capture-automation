<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KickoutFile extends Model
{
    //
    protected $table = 'kickoutFiles';
    protected $primaryKey = 'kickoutFileID';
    public $timestamps = false;
    
    
    // Relationships
    /**
     * partner file for this kickout file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partnerFile()
    {
        return $this->belongsTo('App\Models\PartnerFile', 'partnerFileID', 'partnerFileID');
    }
}
