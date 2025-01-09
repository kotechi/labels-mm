<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Contact;
use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ConsoleTVs\Charts\Facades\Charts;

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

        // Create a chart
        $chart = Charts::create('line', 'highcharts')
            ->title('Sample Chart')
            ->labels(['January', 'February', 'March'])
            ->values([10, 25, 13])
            ->dimensions(0, 400); // Width x Height

        return view('admin.web.index', compact('abouts', 'contacts', 'headers', 'chart'));
    }

    protected function getModel($type)
    {
        if (!array_key_exists($type, $this->models)) {
            abort(404);
        }
        return $this->models[$type];
    }
}
