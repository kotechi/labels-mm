<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Contact;
use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    protected $models = [
        'about' => About::class,
        'contact' => Contact::class,
        'header' => Header::class,
    ];

    public function index()
    {
        $abouts = About::all();
        $contacts = Contact::all();
        $headers = Header::all();
        return view('admin.web.index', compact('abouts', 'contacts', 'headers'));
    }



    protected function getModel($type)
    {
        if (!array_key_exists($type, $this->models)) {
            abort(404);
        }
        return $this->models[$type];
    }
}
