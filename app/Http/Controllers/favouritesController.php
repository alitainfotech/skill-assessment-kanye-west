<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\favouritesModal;
use Auth;
use Response;
use Inertia\Inertia;

class favouritesController extends Controller
{
    public function addToFavourites(Request $request)
    {
        $id = Auth::user()->id;
        $data = new favouritesModal;
        $data->quote = $request->quote;
        $data->user_id = $id;
        $data->save();
        return Response::json(['msg'=>'favorites add succesfully',"data"=>$request->quote]);
    }

    public function show() 
    {
        $favouriteQuotes = $this->getFavoritesQuotes();
        $favouriteQuotes = json_encode($favouriteQuotes);

        return Inertia::render('Pages/FavouriteQuotes', [
            'data' => $favouriteQuotes
        ]);
    }

    public function getFavoritesQuotes()
    {
        $id = Auth::user()->id;
        $data = favouritesModal::where('user_id',$id)->get();
        return $data;
    }

    public function deleteFavoriteQuote($id)
    {
        favouritesModal::find($id)->delete();
    }
}
