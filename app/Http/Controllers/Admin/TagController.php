<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Models\Tag;
use App\Models\Englishdictionary;

class TagController extends Controller
{
    protected $tag;
    protected $english;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Tag $tag, Englishdictionary $english)
    {
        $this->english = $english;
        $this->tag = $tag;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tags_fetch = $this->tag->query()->orderBy('created_at', 'DESC')->get();
        
        return view('tags', ['tags_fetch' => $tags_fetch]);
    }

    public function addFeaturedTag(Request $request)
    {
        $cnt = $this->tag->query()->where('name', $request->name)->get()->count();
        if($cnt != 0)
            return redirect()->back()->with('warning', 'Duplicate Featured Tag Name');

        $this->tag->create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Featured Tag Added.');
    }

    public function destroy($id)
    {
        $this->tag->find($id)->delete();
        return redirect()->back()->with('success', 'Featured Tag Deleted.');
    }

    // APIs for tags and dictionary
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $available_tags = array();
        
        $results = $this->english->query()->where('key_phrase', 'LIKE', '%'. $keyword. '%')->get();
        foreach($results as $word)
            array_push($available_tags, $word->key_phrase);

        $results2 = $this->tag->query()->where('name', 'LIKE', '%'. $keyword. '%')->get();
        foreach($results2 as $word)
            array_push($available_tags, $word->name);

        return json_encode($available_tags);
    }
}
