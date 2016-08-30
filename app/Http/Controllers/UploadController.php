<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input as Input;
use App\Models\ClientFile;

class UploadController extends Controller
{
    
    
    /**
     * @param $files
     * @return string
     */
    public function check_duplicates($files)
    {
        
        $data['file'] = $files;
        
        $uploadFolder = public_path() . '/uploads/';
        
        if (file_exists($uploadFolder . $files)) {
            $result = "already exists";
        } else {
            $result = "false";
        }
        
        return $result;
    }
}
