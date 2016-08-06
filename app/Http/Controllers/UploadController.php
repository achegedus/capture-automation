<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input as Input;
use App\Models\ClientFile;


class UploadController extends Controller
{
    public function client_upload($clientID){

      $history = ClientFile::where('clientID', '=', $clientID)->orderBy('uploadTimestamp', 'desc')->get();
      $data = ['data' => $history ];

      return view('upload', $data);
    }


}
