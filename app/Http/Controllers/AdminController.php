<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;
use DB;

class AdminController extends Controller
{
    
    public function clientList() {
        
        $clientList = Client::orderBy('clientName')->get();
        $data = ['clientList' => $clientList];
            
        return view('admin.main', $data);
    }
    
    
}
