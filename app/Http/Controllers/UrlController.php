<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //create the url
        if ($request->isMethod('POST')) {
            $request->validate([
                'url' => 'required|url|unique:urls',
            ]);

            $input['url'] = $request->url;
            $input['short_url'] = Str::random(6);

            Url::create($input);

            return back()->with('success', 'Short Url Generated Successfully!');
        }

        return view('index');
    }

    public function get()
    {
        $urls = Url::latest()->get();

        foreach ($urls as $url) {
            $url['full_short_url'] = route('short.url', $url->short_url);
        }

        return response()->json($urls);
    }

    //redirect to the long url
    public function shortUrl($shortUrl)
    {
        $url = Url::where('short_url', $shortUrl)->first();

        return redirect($url->url);
    }

    //update the number of click after user click the link
    public function track(Request $request)
    {
        Url::where('short_url', $request->url)->increment('no_clicked', 1);
    }
}
