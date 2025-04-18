<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\About;

class CompanyProfileController extends Controller
{
    public function index() {
        $header = Header::all();
        $about = About::all();
        return view('admin.company.index', compact('header', 'about'));
    }
}
