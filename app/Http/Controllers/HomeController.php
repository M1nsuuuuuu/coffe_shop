<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $drinks = Drink::all();
        return view('home', compact('drinks'));
    }

    public function hits()
    {
        $drinks = Drink::where('is_hit', true)->get();
        return view('hits', compact('drinks'));
    }

    public function newItems()
    {
        $drinks = Drink::where('is_new', true)->get();
        return view('new-items', compact('drinks'));
    }

    public function discounts()
    {
        $drinks = Drink::where('is_discount', true)->get();
        return view('discounts', compact('drinks'));
    }
}