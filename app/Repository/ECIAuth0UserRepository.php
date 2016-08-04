<?php namespace App\Repository;

use App\Models\ECIAuth0User;
use Auth0\Login\Repository\Auth0UserRepository;

class ECIAuth0UserRepository extends Auth0UserRepository {
    
    public function getUserByUserInfo($userInfo) {
        return new ECIAuth0User($userInfo['profile'], $userInfo['accessToken']);
    }
}