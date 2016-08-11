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
        $client = Client::find($clientID);
    
        $history = $client->ClientFiles()->orderBy('uploadTimestamp', 'desc')->get();
        
        return view('admin.history', ['history' => $history]);
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
        // decode JSON from form post
        $decode = json_decode($request->clientEmail);
        // make string comma separated
        $converted = implode(',', $decode);        
        
        $client = Client::find($clientID);
        $client->clientName = $request->clientName;
        $client->username = $request->username;
        $client->clientEmail = $converted;
        $client->catalogServiceID = $request->catalogServiceID;
        $client->datasource = $request->datasource;
        $client->ECMA_start = $request->ECMA_start;
        $client->ECMA_renew = $request->ECMA_renew;
        $client->invoiceSchedule = $request->invoiceSchedule;
        $client->SLA = $request->SLA;
        if(!$request->has('isHosted')) { $request->isHosted = '0'; }
            $client->isHosted = $request->isHosted;
        if(!$request->has('multi_tenant')) { $request->multi_tenant = '0'; }
            $client->multi_tenant = $request->multi_tenant;
        if(!$request->has('onHold')) { $request->onHold = '0'; }
            $client->onHold = $request->onHold; 
        if(!$request->has('batchOverride')) { $request->batchOverride = '0'; }
            $client->batchOverride = $request->batchOverride;
        if(!$request->has('setAccountPeriod')) { $request->setAccountPeriod = '0'; }
            $client->setAccountPeriod = $request->setAccountPeriod;
        if(!$request->has('transAlert')) { $request->transAlert = '0'; }
        $client->transactions_alert = $request->transAlert;        
        $client->ownerID = $request->ownerID;
        $client->kickoutGracePeriod = $request->gracePeriod;
        $client->usage_alert_percent = $request->usagePercent;
        $client->batchPrefix = $request->livePrefix.="_";
        $client->historyPrefix = $request->historyPrefix.="_";
        $client->maintPrefix = $request->maintPrefix.="_";
        $client->proposedVolume_livebills = $request->liveVol;
        $client->proposedVolume_histbills = $request->historicalVol;
        $client->proposedVolume_accts = $request->accountsVol;
        
        $client->save();
    }
    
    
}
