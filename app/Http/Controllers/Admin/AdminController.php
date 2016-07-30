<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;
use App\Models\ClientFile;

class AdminController extends Controller
{
    
    public function clientList()
    {
        $clientList = Client::orderBy('clientName')->get();
        $data = ['clientList' => $clientList];
        
        return view('admin.main', $data);
    }
    
    public function summary($clientID)
    {
        $client = Client::find($clientID);
        if ($client) {
            $data = ['client'       => $client,
                     'transactions' => $client->transaction_data(),
                     'batch'        => $client->batch_detail(),
                     'monthly'      => $client->monthly_detail(),
                     'ecmapercent'  => $client->ECMAPercentage()
            ];
            
            return view('admin.summary', $data);
        }
    }
    
    public function history($clientID)
    {
        $h = ClientFile::where('clientID', '=', $clientID)->orderBy('uploadTimestamp', 'desc')->get();
        $data = ['data' => $h];
        
        return view('admin.history', $data);
    }
    
    public function settings($clientID)
    {
        $client = Client::find($clientID);
        if ($client) {
            $data = ['data' => $client];
            
            return view('admin.settings', $data);
        }
    }
    
    
}
