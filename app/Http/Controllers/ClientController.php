<?php

namespace App\Http\Controllers;

use Adldap\Exceptions\AdldapException;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    
    public function index()
    {
        if (Auth::check()) {
            
            if (Auth::user()->bill_capture_client != '') {
                $client = Client::where('username', '=', Auth::user()->bill_capture_client)->first();
                $data = ['client' => $client];
                
                return view('welcome', $data);
            } else {
                // not a bill capture user
                echo "test";
            }
        } else {
            return view('welcome');
        }
    }
    
    
    public function testSummary($clientID)
    {
        $client = Client::find($clientID);
        if ($client) {
            $data = ['client' => $client, 'transactions' => $client->transaction_data(), 'batch' => $client->batch_detail(), 'monthly' => $client->monthly_detail(), 'ecmapercent' => $client->ECMAPercentage()];
            
            return view('admin.summary', $data);
        }
    }

}
