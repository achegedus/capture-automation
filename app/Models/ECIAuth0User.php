<?php namespace App\Models;


use Adldap\Laravel\Facades\Adldap;
use Auth0\Login\Auth0User;

class ECIAuth0User extends Auth0User
{
    
    function isECBCAdmin()
    {
        $search = Adldap::search()->whereMail($this->email)->first();
        
        $groups = $search->memberof;
        
        $pattern = 'ECBC Admins';
        
        foreach ($groups as $group) {
            if (stripos($group, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
}