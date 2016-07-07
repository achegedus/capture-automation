<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    //
    protected $table = 'partners';
    protected $primaryKey = 'partnerID';
    public $timestamps = false;
    // protected $fillable = ['partnerName', 'partnerCode'];


    // Relationships

    public function partnerFiles() 
    {
        return $this->hasMany('App\Models\PartnerFile', 'partnerID', 'partnerID');
    }
}
