<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;
use Validator;
use Auth;
use App\Models\favouritesModal;

class ApiController extends Controller
{
    public function unAuthnticated()
    {
        return response()->json([
            'success' => false,
            'message' => 'unAunticated',
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Token')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    public function generateQuotes($count)
    {
        $quotes = array();
        
        for($i=1; $i<=$count; $i++){
            $response = Http::get('https://api.kanye.rest');
            $data = $response->json();
            
            array_push($quotes,$data);
        }
        return response()->json([
            'success' => true,
            'message' => $quotes,
        ], 200);
        return $quotes;
    }

    public function getFavorites()
    {
        $id = Auth::user()->id;
        $data = favouritesModal::where('user_id',$id)->get();
        // return $data;
        return response()->json([
            'success' => true,
            'message' => $data,
        ], 200);
    }

    public function deleteQuote($id)
    {
        $userId = Auth::user()->id;
        // dd($userId);
        $query = favouritesModal::where(['id'=>$id,'user_id'=>$userId])->first();
        if(!empty($query)){
            $deleteFavourites = favouritesModal::find($id)->where('id',$userId)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Quote deleted succesfully',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Somthing went wrong',
        ], 200);
    }

    public function logout()
    {
        // Auth::logout();
        Auth::user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Loged out succesfully',
        ], 200);
    }
}
