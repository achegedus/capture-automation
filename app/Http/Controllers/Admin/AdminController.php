<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;
use App\Models\ClientFile;
use App\Models\CatalogService;

class AdminController extends Controller
{
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clientList()
    {
        $clientList = Client::orderBy('clientName')->get();
        $data = ['clientList' => $clientList];
        
        return view('admin.main', $data);
    }
    
    
    /**
     * @param $clientID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
    
    
    /**
     * @param $clientID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function history($clientID)
    {
        $h = ClientFile::where('clientID', '=', $clientID)->orderBy('uploadTimestamp', 'desc')->get();
        $data = ['data' => $h];
        
        return view('admin.history', $data);
    }
    
    
    /**
     * @param $clientID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings($clientID)
    {
        $client = Client::find($clientID);
        $catalogData = CatalogService::pluck('catalogServiceName', 'catalogServiceID');
        
        if ($client) {
            $data = ['client'      => $client,
                     'catalogData' => $catalogData
            ];
            
            return view('admin.settings', $data);
        }
    }
    
    
    /**
     * @param Request $request
     * @param $clientID
     */
    public function formSubmit(Request $request, $clientID)
    {
        $client = Client::find($clientID);
        $client->clientName = $request->clientName;
        $client->username = $request->username;
        $client->clientEmail = $request->clientEmail;
        $client->catalogServiceID = $request->catalogServiceID;
        $client->datasource = $request->datasource;
//        $client->ECMA_start = $request->ECMA_start;
//        $client->ECMA_renew = $request->ECMA_renew;
        $client->invoiceSchedule = $request->invoiceSchedule;
        $client->SLA = $request->SLA;
        $client->save();
    }
    
    
}
