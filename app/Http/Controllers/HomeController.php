<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Header;
use App\Models\About;
use App\Models\Contact;





class HomeController extends Controller
{
    public function index()
    {
        return redirect(route('home'));
    }
}
