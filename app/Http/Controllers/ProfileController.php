<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('drinks')->latest()->get();
        $favorites = $user->favoriteDrinks()->get();
        
        return view('profile', compact('user', 'orders', 'favorites'));
    }
}