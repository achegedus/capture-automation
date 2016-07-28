<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;

class AdminController extends Controller
{
    
    public function clientList() {
        
        $clientList = Client::orderBy('clientName')->get();
        $data = ['clientList' => $clientList];
            
        return view('admin.main', $data);
    }
    
    public function summary($clientID) {

        $client = Client::find($clientID);
        if ($client) {
            $data = ['client' => $client, 
                     'transactions' => $client->transaction_data(), 
                     'batch' => $client->batch_detail(),
                     'monthly' => $client->monthly_detail(),
                     'ecmapercent' => $client->ECMAPercentage()];

            return view('admin.summary', $data);
        }
    }    
    
    
}
