<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrinkController extends Controller
{
    public function show($id)
    {
        $drink = Drink::findOrFail($id);
        $isFavorite = false;
        
        if (Auth::check()) {
            $isFavorite = Favorite::where('user_id', Auth::id())
                ->where('drink_id', $id)
                ->exists();
        }
        
        return view('drinks.show', compact('drink', 'isFavorite'));
    }

    public function toggleFavorite($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('drink_id', $id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'drink_id' => $id,
            ]);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }
}