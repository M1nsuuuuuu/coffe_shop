<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for a drink
     */
    public function toggle(Request $request, $drinkId)
    {
        $user = Auth::user();
        
        $favorite = Favorite::where('user_id', $user->id)
            ->where('drink_id', $drinkId)
            ->first();
            
        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'drink_id' => $drinkId
            ]);
            return response()->json(['status' => 'added']);
        }
    }
    
    /**
     * Remove a drink from favorites
     */
    public function remove(Request $request, $drinkId)
    {
        $user = Auth::user();
        
        $favorite = Favorite::where('user_id', $user->id)
            ->where('drink_id', $drinkId)
            ->first();
            
        if ($favorite) {
            $favorite->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
}
