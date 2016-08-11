<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerFile extends Model
{
    //
    protected $table = 'partnerFiles';
    protected $primaryKey = 'partnerFileID';
    public $timestamps = false;
    
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['processDate', 'closeDate', 'downloadTimestamp', 'lastKickoutEmail'];
    
    // Relationships
    /**
     * Client for this partner file
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'clientID', 'clientID');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kickoutFiles()
    {
        return $this->hasMany('App\Models\KickoutFile', 'partnerFileID', 'partnerFileID');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo('App\Models\Partner', 'partnerID', 'partnerID');
    }
    
    public function clientFile()
    {
        return $this->belongsTo('App\Models\ClientFile', 'clientFileID', 'clientFileID');
    }
}
