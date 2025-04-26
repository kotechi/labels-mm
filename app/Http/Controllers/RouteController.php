<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Header;
use App\Models\About;
class RouteController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $headers = Header::first();
        $abouts = About::first();
        return view('welcome', compact('products', 'headers', 'abouts'));
    }
}
