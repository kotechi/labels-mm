<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        return view('welcome');
        // if (auth()->user()->usertype == 'admin') {
        //     return redirect()->route('admin.index');
        // } elseif (auth()->user()->usertype == 'karyawan') {
        //     return redirect()->route('karyawan.index');
        // }
    }
}
