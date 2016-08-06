<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input as Input;
use App\Models\ClientFile;

class UploadController extends Controller
{
    public function client_upload($clientID){
      $history = ClientFile::find($clientID);
      //$clientfile = ClientFile::where('clientID','=',$clientID)->orderBy('uploadTimestamp', 'desc')->get();
      $data = ['clientFiles' => $history];


      return view('upload',$data);
    }

    /*
    ** Function to list files in the current upload directory **
    */
    // public function list_upload(){
    //   $result = array();
    //   $ds = DIRECTORY_SEPARATOR;
    //   $uploadFolder = public_path() . '/uploads/';
    //   $files = scandir($uploadFolder);
    //
    //   if ( false!==$files ) {
    //     foreach ( $files as $file ) {
    //         if ( '.'!=$file && '..'!=$file) {       //2
    //             $obj['name'] = $file;
    //             $obj['size'] = filesize($uploadFolder.$ds.$file);
    //             $obj['moddate'] = filemtime($uploadFolder.$ds.$file);
    //             $result[] = $obj;
    //         }
    //     }
    // }
    //
    // header('Content-type: text/json');              //3
    // header('Content-type: application/json');
    // echo json_encode($result);
    // }
}
