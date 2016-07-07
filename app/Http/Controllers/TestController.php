<?php

namespace App\Http\Controllers;

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
            $data = ['client' => $client, 'transactions' => $client->transaction_data()];

            return view('admin.summary', $data);
        }
    }
}
