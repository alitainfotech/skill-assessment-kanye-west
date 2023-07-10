<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use Inertia\Inertia;
use App\Models\favouritesModal;


class kanyeController extends Controller
{
    public function get_quote()
    {
        $quotes = array();
        
        for($i=1; $i<=5; $i++){
            $response = Http::get('https://api.kanye.rest');
            $data = $response->json();
            
            array_push($quotes,$data);
        }
        
        return $quotes;
    }
}
