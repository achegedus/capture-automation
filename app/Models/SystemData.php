<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemData extends Model
{
    //
    protected $table = 'systemData';
    protected $primaryKey = 'systemDataID';
    
    public $timestamps = false;
    
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['timestamp', 'notifyTimestamp'];
    
    
}
