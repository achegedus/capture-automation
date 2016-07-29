<?php

namespace App\Http\Controllers;

use Adldap\Exceptions\AdldapException;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;

class TestController extends Controller
{
    //

    public function index() {
        $client = Client::find(20);
        $data = ['client' => $client];

        return view('welcome', $data);
    }


    public function testSummary($clientID) {

        $client = Client::find($clientID);
        if ($client) {
            $data = ['client' => $client, 'transactions' => $client->transaction_data(), 'batch' => $client->batch_detail(),'monthly' => $client->monthly_detail(),'ecmapercent' => $client->ECMAPercentage()];

            return view('admin.summary', $data);
        }
    }
    
    
    public function auth() {
    
//        dd('test');
        return view('auth0test');
//
        
//        try {
//            // Authenticating.
//            if (Adldap::auth()->attempt($username, $password, $bindAsUser = true)) {
//                // Passed!
//                echo 'hello';
//            } else {
//                echo 'nope';
//            }
//        } catch( AdldapException $e)
//        {
//            dd($e);
//        }
    }
}
