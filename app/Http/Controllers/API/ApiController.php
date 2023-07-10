<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;


class ApiController extends Controller
{
    public function generateQuotes($count)
    {
        $quotes = array();
        
        for($i=1; $i<=$count; $i++){
            $response = Http::get('https://api.kanye.rest');
            $data = $response->json();
            
            array_push($quotes,$data);
        }
        
        return $quotes;
    }
}
