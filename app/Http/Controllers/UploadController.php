<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UploadController extends Controller
{
    public function client_upload(){
      return view('upload');
    }

    public function upload_process(){
      echo "tried upload";
    }
}
