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
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check()) {
            
            if (Auth::user()->bill_capture_client != '') {
                $client = Client::where('username', '=', Auth::user()->bill_capture_client)->first();
                
                $history = $client->ClientFiles()->orderBy('uploadTimestamp', 'desc')->get();
    
                return view('upload', ['history' => $history]);
            } else {
                // not a bill capture user
                redirect('/logout');
            }
        } else {
            return view('login');
        }
    }
    
    
    /**
     * @param $clientID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testSummary($clientID)
    {
        $client = Client::find($clientID);
        if ($client) {
            $data = ['client' => $client, 'transactions' => $client->transaction_data(), 'batch' => $client->batch_detail(), 'monthly' => $client->monthly_detail(), 'ecmapercent' => $client->ECMAPercentage()];
            
            return view('admin.summary', $data);
        }
    }
    
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stats()
    {
        $client = Client::where('username', '=', Auth::user()->bill_capture_client)->first();
        
        if ($client) {
            $data = ['client'       => $client,
                     'transactions' => $client->transaction_data(),
                     'batch'        => $client->batch_detail(),
                     'monthly'      => $client->monthly_detail(),
                     'ecmapercent'  => $client->ECMAPercentage()
            ];
            
            return view('stats', $data);
        } else {
            redirect('/logout');
        }
    }
}
